<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class ForgetPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('auth.pages.forget-password.index');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
        ]);

        $user = User::where('email', $request->email)->first();

        // Generate new OTP
        $otpCode = Otp::generate();

        // Update or create OTP (otomatis replace yang lama)
        Otp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp' => $otpCode,
                'is_used' => false,
                'expired_at' => Carbon::now()->addMinutes(5),
            ]
        );

        // Send OTP via email
        try {
            Mail::to($request->email)->send(new OtpMail($otpCode, $user->name));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengirim email. Silakan coba lagi.');
        }

        // Gunakan session()->put() agar persistent
        session()->put('reset_email', $request->email);

        return redirect()->route('verify-otp')
            ->with('success', 'Kode OTP telah dikirim ke email Anda');
    }

    public function showVerifyOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('forget-password')
                ->with('error', 'Silakan masukkan email terlebih dahulu');
        }

        return view('auth.pages.forget-password.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ], [
            'otp.required' => 'Kode OTP harus diisi',
            'otp.size' => 'Kode OTP harus 6 digit',
        ]);

        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('forget-password')
                ->with('error', 'Sesi telah berakhir, silakan ulangi proses');
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
            return back()->with('error', 'Kode OTP telah kadaluarsa');
        }

        // Mark OTP as used (jangan dihapus, biar ada record)
        $otp->update(['is_used' => true]);

        return redirect()->route('reset-password')
            ->with('success', 'Verifikasi berhasil, silakan reset password Anda');
    }

    public function showResetPasswordForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('forget-password')
                ->with('error', 'Silakan verifikasi email dan OTP terlebih dahulu');
        }

        return view('auth.pages.forget-password.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        $email = session('reset_email');
        if (!$email) {
            return redirect()->route('forget-password')
                ->with('error', 'Sesi telah berakhir, silakan ulangi proses');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return redirect()->route('forget-password')
                ->with('error', 'User tidak ditemukan');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clear session
        session()->forget('reset_email');

        return redirect()->route('login')
            ->with('success', 'Password berhasil direset, silakan login dengan password baru');
    }
}
