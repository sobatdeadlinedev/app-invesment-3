<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Redirect jika sudah login
        if (Auth::check()) {
            return $this->redirectBasedOnRole();
        }

        return view('auth.pages.login.index');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Username atau nomor telepon harus diisi',
            'password.required' => 'Password harus diisi',
        ]);

        $loginField = $request->input('login');
        $password = $request->input('password');

        // Cek apakah input adalah nomor telepon atau username
        $fieldType = filter_var($loginField, FILTER_VALIDATE_REGEXP, [
            'options' => ['regexp' => '/^[0-9]+$/']
        ]) ? 'phone' : 'username';

        // Attempt login
        if (Auth::attempt([$fieldType => $loginField, 'password' => $password], $request->filled('remember'))) {
            $request->session()->regenerate();

            return $this->redirectBasedOnRole();
        }

        throw ValidationException::withMessages([
            'login' => 'Username/nomor telepon atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    private function redirectBasedOnRole()
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard.index');
        }

        return redirect()->route('member.dashboard.index');
    }
}
