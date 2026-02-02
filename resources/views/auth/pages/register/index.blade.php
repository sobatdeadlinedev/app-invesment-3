<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ url('/') }}/" />
    <title>{{ $appConfig['app_name']['value'] }}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ $appConfig['app_logo']['value'] }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;700&display=swap"
        rel="stylesheet">
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --gold: #FFD700;
            --gold-dark: #DAA520;
            --gold-light: #FFED4E;
            --silver: #C0C0C0;
            --silver-light: #E5E5E5;
            --silver-dark: #9A9A9A;
            --black: #0A0A0A;
            --black-light: #1A1A1A;
            --black-lighter: #2A2A2A;
            --success: #10B981;
            --success-light: #34D399;
            --error: #EF4444;
            --error-light: #FCA5A5;
        }

        html {
            height: 100%;
            background: var(--black);
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--black);
            color: var(--silver-light);
            min-height: 100%;
            overflow-x: hidden;
        }

        /* Animated Background */
        .register-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 40px 20px;
            background: var(--black);
        }

        .register-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 20%, rgba(255, 215, 0, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(192, 192, 192, 0.05) 0%, transparent 50%);
            animation: pulse 8s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.6;
            }
        }

        /* Grid Pattern Overlay */
        .grid-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image:
                linear-gradient(rgba(255, 215, 0, 0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255, 215, 0, 0.03) 1px, transparent 1px);
            background-size: 50px 50px;
            pointer-events: none;
            opacity: 0.3;
        }

        /* Register Container */
        .register-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 540px;
            background: linear-gradient(145deg, rgba(26, 26, 26, 0.9), rgba(10, 10, 10, 0.95));
            border: 1px solid rgba(192, 192, 192, 0.1);
            border-radius: 24px;
            padding: 48px 40px;
            backdrop-filter: blur(20px);
            box-shadow:
                0 20px 60px rgba(0, 0, 0, 0.5),
                0 0 1px rgba(255, 215, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
            animation: slideUp 0.6s ease-out;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Logo */
        .logo-wrapper {
            text-align: center;
            margin-bottom: 32px;
        }

        .logo-wrapper img {
            width: 120px;
            height: auto;
            /* filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.3)); */
            animation: logoGlow 3s ease-in-out infinite;
        }

        @keyframes logoGlow {

            0%,
            100% {
                filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.3));
            }

            50% {
                filter: drop-shadow(0 0 30px rgba(255, 215, 0, 0.5));
            }
        }

        /* Header */
        .register-header {
            text-align: center;
            margin-bottom: 32px;
        }

        .register-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .register-header p {
            font-size: 14px;
            color: var(--silver-dark);
            font-weight: 400;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--silver);
            margin-bottom: 8px;
            letter-spacing: 0.3px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gold);
            font-size: 18px;
            pointer-events: none;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .form-control {
            width: 100%;
            padding: 14px 16px 14px 48px;
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(192, 192, 192, 0.15);
            border-radius: 12px;
            font-size: 14px;
            color: #FFFFFF;
            font-family: 'DM Sans', sans-serif;
            transition: all 0.3s ease;
            outline: none;
        }

        .form-control::placeholder {
            color: rgba(192, 192, 192, 0.4);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
        }

        .form-control:focus+.input-icon {
            color: var(--gold-light);
        }

        .form-control.is-invalid {
            border-color: var(--error);
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--silver-dark);
            cursor: pointer;
            padding: 4px;
            transition: color 0.3s ease;
            font-size: 18px;
            z-index: 3;
        }

        .password-toggle:hover {
            color: var(--gold);
        }

        /* Form Text */
        .form-text {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: var(--silver-dark);
        }

        /* Invalid Feedback */
        .invalid-feedback {
            display: block;
            margin-top: 6px;
            font-size: 12px;
            color: var(--error-light);
        }

        /* Submit Button */
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-dark) 100%);
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            font-family: 'Syne', sans-serif;
            color: var(--black);
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(255, 215, 0, 0.3);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 30px rgba(255, 215, 0, 0.4);
        }

        .btn-submit:hover::before {
            left: 100%;
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        /* Sign In Link */
        .signin-link {
            text-align: center;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid rgba(192, 192, 192, 0.1);
            font-size: 14px;
            color: var(--silver-dark);
        }

        .signin-link a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
            margin-left: 4px;
            transition: color 0.3s ease;
        }

        .signin-link a:hover {
            color: var(--gold-light);
        }

        /* Alert Styles */
        .alert {
            padding: 16px;
            margin-bottom: 24px;
            border-radius: 12px;
            display: flex;
            gap: 12px;
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .alert-danger i {
            color: var(--error);
            font-size: 20px;
            flex-shrink: 0;
        }

        .alert-content h5 {
            font-size: 13px;
            font-weight: 700;
            color: var(--error);
            margin-bottom: 4px;
        }

        .alert-content span {
            font-size: 12px;
            color: var(--error-light);
            display: block;
            line-height: 1.5;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .alert-success i {
            color: var(--success);
            font-size: 20px;
            flex-shrink: 0;
        }

        .alert-success .alert-content h5 {
            color: var(--success);
        }

        .alert-success .alert-content span {
            color: var(--success-light);
        }

        /* Two Column Layout for Desktop */
        @media (min-width: 768px) {
            .form-row {
                display: grid;
                grid-template-columns: 1fr 1fr;
                gap: 16px;
            }

            .form-row .form-group {
                margin-bottom: 20px;
            }
        }

        /* Responsive */
        @media (max-width: 480px) {
            .register-container {
                padding: 36px 28px;
            }

            .register-header h1 {
                font-size: 24px;
            }

            .form-control {
                padding: 12px 14px 12px 44px;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--black-light);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gold-dark);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold);
        }

        /* Loading Animation */
        .btn-submit.loading {
            pointer-events: none;
            opacity: 0.7;
        }

        .btn-submit.loading::after {
            content: '';
            position: absolute;
            width: 16px;
            height: 16px;
            top: 50%;
            left: 50%;
            margin-left: -8px;
            margin-top: -8px;
            border: 2px solid var(--black);
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>

<body id="kt_body" class="app-blank">
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>

    <div class="register-wrapper">
        <div class="grid-overlay"></div>

        <div class="register-container">
            <!-- Logo -->
            <div class="logo-wrapper">
                <img alt="Logo" src="{{ $appConfig['app_logo']['value'] }}" />
            </div>

            <!-- Header -->
            <div class="register-header">
                <h1>Create New Account</h1>
                <p>Sign up to start trading with {{ $appConfig['app_name']['value'] }}</p>
            </div>

            <!-- Register Form -->
            <form class="form" method="POST" action="{{ route('register.post') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="ki-duotone ki-shield-cross">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="alert-content">
                            <h5>Registration Error</h5>
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Referral Code Info (if exists) -->
                @if ($referralCode && $referrer)
                    <div class="alert alert-success">
                        <i class="ki-duotone ki-shield-tick">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                @endif

                <!-- Full Name Input -->
                <div class="form-group">
                    <label class="form-label">Full Name</label>
                    <div class="input-wrapper">
                        <input type="text" placeholder="Enter your full name" name="name" autocomplete="off"
                            value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror"
                            required />
                        <i class="ki-duotone ki-user input-icon">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Username Input -->
                <div class="form-group">
                    <label class="form-label">Username</label>
                    <div class="input-wrapper">
                        <input type="text" placeholder="Choose a username" name="username" autocomplete="off"
                            value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror"
                            required />
                        <i class="ki-duotone ki-profile-user input-icon">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email & Phone Row -->
                <div class="form-row">
                    <!-- Email Input -->
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <div class="input-wrapper">
                            <input type="email" placeholder="Enter your email" name="email" autocomplete="off"
                                value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror"
                                required />
                            <i class="ki-duotone ki-sms input-icon">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Phone Input -->
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <div class="input-wrapper">
                            <input type="text" placeholder="08xxxxxxxxxx" name="phone" autocomplete="off"
                                value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror"
                                required />
                            <i class="ki-duotone ki-phone input-icon">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">Number will be automatically formatted to 62xxx</div>
                    </div>
                </div>

                <!-- Password & Confirm Password Row -->
                <div class="form-row">
                    <!-- Password Input -->
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <input type="password" placeholder="Create a password" name="password" id="password"
                                autocomplete="off" class="form-control @error('password') is-invalid @enderror"
                                required />
                            <i class="ki-duotone ki-lock input-icon">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <button type="button" class="password-toggle"
                                onclick="togglePassword('password', 'password-icon')">
                                <i class="ki-duotone ki-eye" id="password-icon">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
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
                            <input type="password" placeholder="Confirm your password" name="password_confirmation"
                                id="password_confirmation" autocomplete="off" class="form-control" required />
                            <i class="ki-duotone ki-lock input-icon">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <button type="button" class="password-toggle"
                                onclick="togglePassword('password_confirmation', 'password-confirmation-icon')">
                                <i class="ki-duotone ki-eye" id="password-confirmation-icon">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                    <span class="path3"></span>
                                </i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Referral Code Input -->
                <div class="form-group">
                    <label class="form-label">Referral Code (Optional)</label>
                    <div class="input-wrapper">
                        <input type="text" placeholder="Enter referral code" name="referral_code"
                            autocomplete="off" value="{{ old('referral_code', $referralCode ?? '') }}"
                            class="form-control @error('referral_code') is-invalid @enderror"
                            {{ $referralCode ? 'readonly' : '' }} />
                        <i class="ki-duotone ki-gift input-icon">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                        </i>
                        @error('referral_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-text">Enter referral code if you have one</div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <span>Create Account</span>
                    <i class="ki-duotone ki-arrow-right">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>

                <!-- Sign In Link -->
                <div class="signin-link">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        var hostUrl = "assets/";

        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<span class="path1"></span><span class="path2"></span>';
                eyeIcon.classList.remove('ki-eye');
                eyeIcon.classList.add('ki-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<span class="path1"></span><span class="path2"></span><span class="path3"></span>';
                eyeIcon.classList.remove('ki-eye-slash');
                eyeIcon.classList.add('ki-eye');
            }
        }

        // Form submit animation
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = document.querySelector('.btn-submit');
            btn.classList.add('loading');
            btn.querySelector('span').textContent = 'Creating Account...';
        });
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
</body>

</html>
