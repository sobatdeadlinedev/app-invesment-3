<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ url('/') }}/" />
    <title>STARS INVESMENT - Forgot Password</title>
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
        .forgot-wrapper {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 20px;
            background: var(--black);
        }

        .forgot-wrapper::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: 
                radial-gradient(circle at 20% 20%, rgba(255, 215, 0, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(192, 192, 192, 0.05) 0%, transparent 50%);
            animation: pulse 8s ease-in-out infinite;
            z-index: 1;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.6; }
        }

        /* Grid Pattern Overlay */
        .grid-overlay {
            position: fixed;
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
            z-index: 1;
        }

        /* Forgot Password Container */
        .forgot-container {
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
        .forgot-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .forgot-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .forgot-header p {
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

        .form-control.is-invalid {
            border-color: var(--error);
        }

        .form-control.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
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

        /* Back to Login Link */
        .back-link {
            text-align: center;
            margin-top: 28px;
            padding-top: 28px;
            border-top: 1px solid rgba(192, 192, 192, 0.1);
            font-size: 14px;
            color: var(--silver-dark);
        }

        .back-link a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
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

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: var(--success-light);
        }

        .alert-success i {
            color: var(--success);
            font-size: 20px;
            flex-shrink: 0;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--error-light);
        }

        .alert-danger i {
            color: var(--error);
            font-size: 20px;
            flex-shrink: 0;
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert li {
            font-size: 13px;
            line-height: 1.6;
        }

        /* Info Badge */
        .info-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 28px;
            padding: 16px;
            background: rgba(255, 215, 0, 0.05);
            border: 1px solid rgba(255, 215, 0, 0.15);
            border-radius: 12px;
        }

        .info-icon {
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

        .info-content h5 {
            font-size: 13px;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 2px;
        }

        .info-content p {
            font-size: 11px;
            color: var(--silver-dark);
            line-height: 1.4;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .forgot-container {
                padding: 36px 28px;
            }

            .forgot-header h1 {
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

    <div class="forgot-wrapper">
        <div class="grid-overlay"></div>
        
        <div class="forgot-container">
            <!-- Logo -->
            <div class="logo-wrapper">
                <img alt="Logo" src="{{ $appConfig['app_logo']['value'] }}" />
            </div>

            <!-- Header -->
            <div class="forgot-header">
                <h1>Forgot Password?</h1>
                <p>Enter your email to receive OTP code</p>
            </div>

            <!-- Forgot Password Form -->
            <form class="form" method="POST" action="{{ route('forget-password.send-otp') }}">
                @csrf

                @if (session('success'))
                    <div class="alert alert-success">
                        <i class="ki-duotone ki-check-circle">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <div>{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        <i class="ki-duotone ki-cross-circle">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="ki-duotone ki-information">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                        </i>
                        <div>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <!-- Email Input -->
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-wrapper">
                        <input 
                            type="email" 
                            placeholder="Enter your email address" 
                            name="email"
                            autocomplete="off" 
                            value="{{ old('email') }}"
                            class="form-control @error('email') is-invalid @enderror"
                            required 
                        />
                        <i class="ki-duotone ki-sms input-icon">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <span>Send OTP Code</span>
                </button>

                <!-- Back to Login Link -->
                <div class="back-link">
                    <a href="{{ route('login') }}">
                        <i class="ki-duotone ki-arrow-left" style="font-size: 16px; vertical-align: middle;">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        Back to Login
                    </a>
                </div>
            </form>

            <!-- Info Badge -->
            <div class="info-badge">
                <div class="info-icon">
                    <i class="ki-duotone ki-information-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                </div>
                <div class="info-content">
                    <h5>How it works</h5>
                    <p>We'll send a verification code to your email. Use it to reset your password securely.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        var hostUrl = "assets/";

        // Form submit animation
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = document.querySelector('.btn-submit');
            btn.classList.add('loading');
            btn.querySelector('span').textContent = 'Sending...';
        });
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
</body>

</html>