<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Otp;
use App\Models\ReferralUsage;
use App\Mail\RegisterOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use Carbon\Carbon;

class RegisterController extends Controller
{
    /**
     * Show registration form
     */
    public function showRegistrationForm(Request $request)
    {
        $referralCode = $request->query('ref');

        $referrer = null;
        if ($referralCode) {
            $referrer = User::where('refferal_code', $referralCode)->first();
        }

        return view('auth.pages.register.index', compact('referralCode', 'referrer'));
    }

    /**
     * Handle registration - validate, store pending data in session, send OTP
     */
    public function register(Request $request)
    {
        // Format phone number
        $phone = $request->phone;
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        $request->merge(['phone' => $phone]);

        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255|unique:users,email',
            'phone'         => 'required|string|max:20|unique:users,phone|regex:/^[0-9]+$/',
            'password'      => ['required', 'confirmed', Password::min(8)],
            'referral_code' => 'required|string|exists:users,refferal_code',
        ], [
            'name.required'          => 'Nama lengkap harus diisi',
            'email.required'         => 'Email harus diisi',
            'email.email'            => 'Format email tidak valid',
            'email.unique'           => 'Email sudah terdaftar',
            'phone.required'         => 'Nomor telepon harus diisi',
            'phone.unique'           => 'Nomor telepon ' . $phone . ' sudah terdaftar. Silakan gunakan nomor lain atau login jika Anda sudah memiliki akun.',
            'phone.regex'            => 'Nomor telepon hanya boleh berisi angka',
            'password.required'      => 'Password harus diisi',
            'password.confirmed'     => 'Konfirmasi password tidak cocok',
            'password.min'           => 'Password minimal 8 karakter',
            'referral_code.required' => 'Kode referral harus diisi',
            'referral_code.exists'   => 'Kode referral tidak valid',
        ]);

        // Store registration data in session (pending verification)
        session()->put('register_pending', [
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $phone,
            'password'      => $request->password, // will be hashed on final save
            'referral_code' => $request->referral_code,
        ]);

        // Generate & save OTP
        $otpCode = Otp::generate();

        Otp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp'        => $otpCode,
                'is_used'    => false,
                'expired_at' => Carbon::now()->addMinutes(10),
            ]
        );

        // Send OTP email
        try {
            Mail::to($request->email)->send(new RegisterOtpMail($otpCode, $request->name));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email OTP. Silakan coba lagi.');
        }

        session()->put('register_email', $request->email);

        return redirect()->route('register.verify-otp')
            ->with('success', 'Kode OTP telah dikirim ke email Anda. Silakan verifikasi untuk menyelesaikan pendaftaran.');
    }

    /**
     * Show OTP verification form for register
     */
    public function showVerifyOtpForm()
    {
        if (!session('register_email') || !session('register_pending')) {
            return redirect()->route('register')
                ->with('error', 'Sesi pendaftaran tidak ditemukan. Silakan daftar ulang.');
        }

        return view('auth.pages.register.verify-otp');
    }

    /**
     * Verify OTP and complete registration
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Kode OTP harus diisi',
            'otp.size'     => 'Kode OTP harus 6 digit',
        ]);

        $email = session('register_email');
        $pendingData = session('register_pending');

        if (!$email || !$pendingData) {
            return redirect()->route('register')
                ->with('error', 'Sesi pendaftaran telah berakhir. Silakan daftar ulang.');
        }

        $otp = Otp::where('email', $email)
            ->where('otp', $request->otp)
            ->first();

        if (!$otp) {
            return back()->with('error', 'Kode OTP tidak valid');
        }

        if ($otp->is_used) {
            return back()->with('error', 'Kode OTP sudah pernah digunakan');
        }

        if ($otp->expired_at < Carbon::now()) {
            return back()->with('error', 'Kode OTP telah kadaluarsa. Silakan daftar ulang.');
        }

        // Mark OTP as used
        $otp->update(['is_used' => true]);

        // Create the user now that OTP is verified
        $user = User::create([
            'name'     => $pendingData['name'],
            'email'    => $pendingData['email'],
            'phone'    => $pendingData['phone'],
            'password' => Hash::make($pendingData['password']),
        ]);

        // Assign default role
        $user->assignRole('member');

        // Save referral usage
        $referrer = User::where('refferal_code', $pendingData['referral_code'])->first();
        if ($referrer) {
            ReferralUsage::create([
                'referrer_id'   => $referrer->id,
                'referred_id'   => $user->id,
                'referral_code' => $pendingData['referral_code'],
                'used_at'       => now(),
            ]);
        }

        // Clear session
        session()->forget(['register_email', 'register_pending']);

        // Auto login
        Auth::login($user);

        return redirect()->route('member.dashboard.index')
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $user->name . '!');
    }

    /**
     * Resend OTP for registration
     */
    public function resendOtp()
    {
        $email = session('register_email');
        $pendingData = session('register_pending');

        if (!$email || !$pendingData) {
            return redirect()->route('register')
                ->with('error', 'Sesi pendaftaran tidak ditemukan. Silakan daftar ulang.');
        }

        $otpCode = Otp::generate();

        Otp::updateOrCreate(
            ['email' => $email],
            [
                'otp'        => $otpCode,
                'is_used'    => false,
                'expired_at' => Carbon::now()->addMinutes(10),
            ]
        );

        try {
            Mail::to($email)->send(new RegisterOtpMail($otpCode, $pendingData['name']));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email OTP. Silakan coba lagi.');
        }

        return back()->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }
}