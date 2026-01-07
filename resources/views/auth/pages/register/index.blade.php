<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ReferralUsage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function index(Request $request)
    {
        $referralCode = $request->query('ref');

        // Validate if referral code exists
        $referrer = null;
        if ($referralCode) {
            $referrer = User::where('refferal_code', $referralCode)->first();
        }

        return view('auth.pages.register.index', compact('referralCode', 'referrer'));
    }

    public function register(Request $request)
    {
        // Format phone number first before validation
        $phone = $request->phone;
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        // Merge formatted phone back to request for validation
        $request->merge(['phone' => $phone]);

        // Validate with custom phone unique check
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username|alpha_dash',
                'email' => 'required|email|max:255|unique:users,email',
                'phone' => 'required|string|max:20|unique:users,phone|regex:/^[0-9]+$/',
                'password' => ['required', 'confirmed', Password::min(8)],
                'referral_code' => 'nullable|string|exists:users,refferal_code',
            ],
            [
                'name.required' => 'Nama lengkap harus diisi',
                'username.required' => 'Username harus diisi',
                'username.unique' => 'Username sudah digunakan',
                'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, dash dan underscore',
                'email.required' => 'Email harus diisi',
                'email.email' => 'Format email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'phone.required' => 'Nomor telepon harus diisi',
                'phone.unique' => 'Nomor telepon ' . $phone . ' sudah terdaftar. Silakan gunakan nomor lain atau login jika Anda sudah memiliki akun.',
                'phone.regex' => 'Nomor telepon hanya boleh berisi angka',
                'password.required' => 'Password harus diisi',
                'password.confirmed' => 'Konfirmasi password tidak cocok',
                'password.min' => 'Password minimal 8 karakter',
                'referral_code.exists' => 'Kode referral tidak valid',
            ],
        );

        // Create user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'phone' => $phone,
            'password' => Hash::make($request->password),
        ]);

        // Assign default role 'member'
        $user->assignRole('member');

        // Save referral usage if referral code is provided
        if ($request->referral_code) {
            $referrer = User::where('refferal_code', $request->referral_code)->first();
            if ($referrer) {
                ReferralUsage::create([
                    'referrer_id' => $referrer->id,
                    'referred_id' => $user->id,
                    'referral_code' => $request->referral_code,
                    'used_at' => now(),
                ]);
            }
        }

        // Auto login setelah register
        Auth::login($user);

        return redirect()->route('member.dashboard.index')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}
