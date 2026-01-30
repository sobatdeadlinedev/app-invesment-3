<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ url('/') }}/" />
    <title>STARS INVESMENT</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
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
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--black);
            color: var(--silver-light);
            overflow-x: hidden;
        }

        /* Animated Background */
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 20px;
            background: var(--black);
        }

        .login-wrapper::before {
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
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
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

        /* Login Container */
        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
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
            margin-bottom: 36px;
        }

        .logo-wrapper img {
            height: 48px;
            filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.3));
            animation: logoGlow 3s ease-in-out infinite;
        }

        @keyframes logoGlow {
            0%, 100% { filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.3)); }
            50% { filter: drop-shadow(0 0 30px rgba(255, 215, 0, 0.5)); }
        }

        /* Header */
        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-header p {
            font-size: 14px;
            color: var(--silver-dark);
            font-weight: 400;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 24px;
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

        .form-control:focus + .input-icon {
            color: var(--gold-light);
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
        }

        .password-toggle:hover {
            color: var(--gold);
        }

        /* Forgot Password */
        .forgot-password {
            text-align: right;
            margin-bottom: 28px;
        }

        .forgot-password a {
            font-size: 13px;
            color: var(--gold);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: var(--gold-light);
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

        /* Sign Up Link */
        .signup-link {
            text-align: center;
            margin-top: 28px;
            padding-top: 28px;
            border-top: 1px solid rgba(192, 192, 192, 0.1);
            font-size: 14px;
            color: var(--silver-dark);
        }

        .signup-link a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
            margin-left: 4px;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: var(--gold-light);
        }

        /* Security Badge */
        .security-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
            padding: 16px;
            background: rgba(255, 215, 0, 0.05);
            border: 1px solid rgba(255, 215, 0, 0.15);
            border-radius: 12px;
        }

        .security-icon {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 215, 0, 0.1);
            border-radius: 8px;
            color: var(--gold);
            font-size: 18px;
        }

        .security-content h5 {
            font-size: 13px;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 2px;
        }

        .security-content p {
            font-size: 11px;
            color: var(--silver-dark);
            line-height: 1.4;
        }

        /* Error Alert */
        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-10px); }
            75% { transform: translateX(10px); }
        }

        .alert-danger i {
            color: #EF4444;
            font-size: 20px;
        }

        .alert-content h5 {
            font-size: 13px;
            font-weight: 700;
            color: #EF4444;
            margin-bottom: 4px;
        }

        .alert-content span {
            font-size: 12px;
            color: #FCA5A5;
            display: block;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .login-container {
                padding: 36px 28px;
            }

            .login-header h1 {
                font-size: 24px;
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
            to { transform: rotate(360deg); }
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

    <div class="login-wrapper">
        <div class="grid-overlay"></div>
        
        <div class="login-container">
            <!-- Logo -->
            <div class="logo-wrapper">
                <img alt="Logo" src="{{ $appConfig['app_logo']['value'] }}" />
            </div>

            <!-- Header -->
            <div class="login-header">
                <h1>Welcome Back</h1>
                <p>Sign in to continue trading</p>
            </div>

            <!-- Login Form -->
            <form class="form" method="POST" action="{{ route('login.post') }}">
                @csrf

                @if ($errors->any())
                    <div class="alert-danger">
                        <i class="ki-duotone ki-shield-cross">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div class="alert-content">
                            <h5>Authentication Failed</h5>
                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Username/Phone Input -->
                <div class="form-group">
                    <label class="form-label">Username or Phone</label>
                    <div class="input-wrapper">
                        <input 
                            type="text" 
                            placeholder="Enter your username or phone" 
                            name="login"
                            autocomplete="off" 
                            value="{{ old('login') }}"
                            class="form-control @error('login') is-invalid @enderror"
                            required 
                        />
                        <i class="ki-duotone ki-user input-icon">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrapper">
                        <input 
                            type="password" 
                            placeholder="Enter your password" 
                            name="password"
                            id="passwordInput" 
                            autocomplete="off"
                            class="form-control @error('password') is-invalid @enderror"
                            required 
                        />
                        <i class="ki-duotone ki-lock input-icon">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="ki-duotone ki-eye" id="eyeIcon">
                                <span class="path1"></span>
                                <span class="path2"></span>
                                <span class="path3"></span>
                            </i>
                        </button>
                    </div>
                </div>

                <!-- Forgot Password -->
                <div class="forgot-password">
                    <a href="{{ route('forget-password') }}">Forgot Password?</a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <span>Sign In</span>
                </button>

                <!-- Sign Up Link -->
                <div class="signup-link">
                    Don't have an account?
                    <a href="{{ route('register') }}">Create Account</a>
                </div>
            </form>

            
    </div>

    <script>
        var hostUrl = "assets/";

        function togglePassword() {
            const passwordInput = document.getElementById('passwordInput');
            const eyeIcon = document.getElementById('eyeIcon');

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
            btn.querySelector('span').textContent = 'Signing In...';
        });
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
</body>

</html>