<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ url('/') }}/" />
    <title>STARS INVESMENT - Register</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f8f9fa;
            min-height: 100vh;
        }

        .login-container {
            display: flex;
            min-height: 100vh;
        }

        .login-left {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            background: #ffffff;
        }

        .login-form-wrapper {
            width: 100%;
            max-width: 500px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 32px;
        }

        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .login-subtitle {
            font-size: 15px;
            color: #6b7280;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px 14px 44px;
            border: 1px solid #d1d5db;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.2s;
            background: #ffffff;
        }

        .form-input:focus {
            outline: none;
            border-color: #7c3aed;
            box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
        }

        .form-input.is-invalid {
            border-color: #ef4444;
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 4px;
        }

        .password-toggle:hover {
            color: #6b7280;
        }

        .form-text {
            font-size: 12px;
            color: #6b7280;
            margin-top: 6px;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #7c3aed 0%, #6366f1 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 24px;
        }

        .btn-login:hover {
            transform: scale(1.02);
            box-shadow: 0 8px 20px rgba(124, 58, 237, 0.3);
        }

        .signup-text {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
        }

        .signup-link {
            font-weight: 600;
            color: #7c3aed;
            text-decoration: none;
            margin-left: 4px;
        }

        .signup-link:hover {
            color: #6d28d9;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-danger {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
        }

        .alert-success {
            background: #f0fdf4;
            border-left: 4px solid #10b981;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .alert ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .alert li {
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-danger li {
            color: #dc2626;
        }

        .alert-danger li:before {
            content: "\f06a";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
        }

        .referral-content {
            flex: 1;
        }

        .referral-title {
            font-size: 16px;
            font-weight: 600;
            color: #065f46;
            margin-bottom: 4px;
        }

        .referral-text {
            font-size: 14px;
            color: #047857;
        }

        .referral-icon {
            color: #10b981;
            font-size: 32px;
        }

        .invalid-feedback {
            color: #ef4444;
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }

        .login-right {
            flex: 1;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 60px 48px;
            color: white;
            position: relative;
            overflow: hidden;
            display: none;
        }

        .bg-decoration {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
        }

        .bg-decoration-1 {
            width: 400px;
            height: 400px;
            top: -100px;
            right: -100px;
            filter: blur(80px);
        }

        .bg-decoration-2 {
            width: 500px;
            height: 500px;
            bottom: -150px;
            left: -150px;
            filter: blur(100px);
        }

        .right-content {
            position: relative;
            z-index: 1;
            max-width: 500px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
            text-align: center;
        }

        .right-logo {
            margin-bottom: 40px;
        }

        .right-logo img {
            max-width: 200px;
            height: auto;
            background: white;
            padding: 30px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
        }

        .right-title {
            font-size: 40px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .right-description {
            font-size: 17px;
            color: rgba(255, 255, 255, 0.95);
            margin-bottom: 50px;
            line-height: 1.6;
        }

        .features-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
            text-align: left;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 16px;
        }

        .feature-check {
            width: 28px;
            height: 28px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .feature-check i {
            font-size: 14px;
        }

        @media (min-width: 1024px) {
            .login-right {
                display: block;
            }
        }

        @media (max-width: 768px) {
            .login-title {
                font-size: 24px;
            }

            .login-form-wrapper {
                max-width: 100%;
            }

            .form-input {
                padding: 12px 16px 12px 40px;
            }
        }
    </style>
</head>

<body id="kt_body" class="app-blank">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                themeMode = defaultThemeMode;
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>

    <div class="login-container">
        <!-- Left Section - Register Form -->
        <div class="login-left">
            <div class="login-form-wrapper">
                <!-- Logo -->
                <div class="logo-container">
                    <img alt="Logo" src="{{ $appConfig['app_logo']['value'] }}" style="max-width: 150px; height: auto; margin-bottom: 24px;" />
                    <h1 class="login-title">Create New Account</h1>
                    <p class="login-subtitle">Sign up to start trading with STARS INVESTMENT</p>
                </div>

                <!-- Register Form -->
                <form class="form w-100" method="POST" action="{{ route('register.post') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Referral Code Info (if exists) -->
                    @if ($referralCode && $referrer)
                        <div class="alert alert-success">
                            <i class="fas fa-shield-check referral-icon"></i>
                            <div class="referral-content">
                                <div class="referral-title">Referral Code Detected</div>
                                <div class="referral-text">You will be registered as a referral from
                                    <strong>{{ $referrer->username }}</strong></div>
                            </div>
                        </div>
                    @endif

                    <!-- Full Name Input -->
                    <div class="form-group">
                        <label class="form-label">Full Name</label>
                        <div class="input-wrapper">
                            <i class="fas fa-user input-icon"></i>
                            <input 
                                type="text" 
                                name="name" 
                                placeholder="Enter your full name"
                                autocomplete="off" 
                                value="{{ old('name') }}"
                                class="form-input @error('name') is-invalid @enderror" 
                                required 
                            />
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Username Input -->
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <div class="input-wrapper">
                            <i class="fas fa-at input-icon"></i>
                            <input 
                                type="text" 
                                name="username" 
                                placeholder="Choose a username"
                                autocomplete="off" 
                                value="{{ old('username') }}"
                                class="form-input @error('username') is-invalid @enderror" 
                                required 
                            />
                            @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email Input -->
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input 
                                type="email" 
                                name="email" 
                                placeholder="Enter your email"
                                autocomplete="off" 
                                value="{{ old('email') }}"
                                class="form-input @error('email') is-invalid @enderror" 
                                required 
                            />
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone Input -->
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <div class="input-wrapper">
                            <i class="fas fa-phone input-icon"></i>
                            <input 
                                type="text" 
                                name="phone" 
                                placeholder="08xxxxxxxxxx"
                                autocomplete="off" 
                                value="{{ old('phone') }}"
                                class="form-input @error('phone') is-invalid @enderror" 
                                required 
                            />
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Number will be automatically formatted to 62xxx</div>
                    </div>

                    <!-- Password Input -->
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                name="password" 
                                id="password"
                                placeholder="Create a password"
                                autocomplete="off"
                                class="form-input @error('password') is-invalid @enderror" 
                                required 
                            />
                            <button 
                                type="button" 
                                class="password-toggle"
                                onclick="togglePassword('password', 'password-icon')"
                            >
                                <i class="fas fa-eye" id="password-icon"></i>
                            </button>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Minimum 8 characters</div>
                    </div>

                    <!-- Confirm Password Input -->
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                name="password_confirmation" 
                                id="password_confirmation"
                                placeholder="Confirm your password"
                                autocomplete="off"
                                class="form-input" 
                                required 
                            />
                            <button 
                                type="button" 
                                class="password-toggle"
                                onclick="togglePassword('password_confirmation', 'password-confirmation-icon')"
                            >
                                <i class="fas fa-eye" id="password-confirmation-icon"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Referral Code Input -->
                    <div class="form-group">
                        <label class="form-label">Referral Code (Optional)</label>
                        <div class="input-wrapper">
                            <i class="fas fa-gift input-icon"></i>
                            <input 
                                type="text" 
                                name="referral_code" 
                                placeholder="Enter referral code"
                                autocomplete="off" 
                                value="{{ old('referral_code', $referralCode ?? '') }}"
                                class="form-input @error('referral_code') is-invalid @enderror"
                                {{ $referralCode ? 'readonly' : '' }}
                            />
                            @error('referral_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Enter referral code if you have one</div>
                    </div>

                    <!-- Sign Up Button -->
                    <button type="submit" class="btn-login">
                        <span>Create Account</span>
                        <i class="fas fa-arrow-right"></i>
                    </button>

                    <!-- Sign In Link -->
                    <div class="signup-text">
                        Already have an account? 
                        <a href="{{ route('login') }}" class="signup-link">Sign in</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Section - Visual -->
        <div class="login-right">
            <div class="bg-decoration bg-decoration-1"></div>
            <div class="bg-decoration bg-decoration-2"></div>
            
            <div class="right-content">
                <div class="right-logo">
                    <img alt="Logo" src="{{ $appConfig['app_logo']['value'] }}" />
                </div>
                
                <h2 class="right-title">Start Trading Today</h2>
                <p class="right-description">Join millions of traders worldwide. Trade cryptocurrencies with confidence on our secure platform.</p>
                
                <div class="features-list">
                    <div class="feature-item">
                        <div class="feature-check">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Secure & Reliable Platform</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-check">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>24/7 Customer Support</span>
                    </div>
                    <div class="feature-item">
                        <div class="feature-check">
                            <i class="fas fa-check"></i>
                        </div>
                        <span>Low Trading Fees</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var hostUrl = "assets/";
        
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
</body>

</html>