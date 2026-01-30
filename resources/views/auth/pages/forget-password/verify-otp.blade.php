<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ url('/') }}/" />
    <title>STARS INVESMENT - Verify OTP</title>
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
        .verify-wrapper {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 20px;
            background: var(--black);
        }

        .verify-wrapper::before {
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

        /* Verify Container */
        .verify-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 480px;
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
        .verify-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .verify-header h1 {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 12px;
            letter-spacing: -0.5px;
        }

        .verify-header p {
            font-size: 14px;
            color: var(--silver-dark);
            font-weight: 400;
            line-height: 1.6;
        }

        .verify-header strong {
            color: var(--gold);
            font-weight: 600;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 32px;
        }

        /* OTP Input Special Styling */
        .otp-input {
            width: 100%;
            padding: 20px;
            background: rgba(255, 255, 255, 0.03);
            border: 2px solid rgba(192, 192, 192, 0.15);
            border-radius: 16px;
            font-size: 32px;
            font-weight: 700;
            color: var(--gold);
            font-family: 'Syne', sans-serif;
            text-align: center;
            letter-spacing: 12px;
            transition: all 0.3s ease;
            outline: none;
        }

        .otp-input::placeholder {
            color: rgba(192, 192, 192, 0.3);
            font-size: 16px;
            letter-spacing: normal;
        }

        .otp-input:focus {
            background: rgba(255, 255, 255, 0.05);
            border-color: var(--gold);
            box-shadow: 0 0 0 4px rgba(255, 215, 0, 0.15);
            transform: scale(1.02);
        }

        .otp-input.is-invalid {
            border-color: var(--error);
        }

        .otp-input.is-invalid:focus {
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.15);
        }

        /* Invalid Feedback */
        .invalid-feedback {
            display: block;
            margin-top: 8px;
            font-size: 12px;
            color: var(--error-light);
            text-align: center;
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

        /* Resend Link */
        .resend-link {
            text-align: center;
            margin-top: 28px;
            padding-top: 28px;
            border-top: 1px solid rgba(192, 192, 192, 0.1);
            font-size: 14px;
            color: var(--silver-dark);
        }

        .resend-link a {
            color: var(--gold);
            text-decoration: none;
            font-weight: 600;
            margin-left: 4px;
            transition: color 0.3s ease;
        }

        .resend-link a:hover {
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

        /* Timer Badge */
        .timer-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 24px;
            padding: 16px;
            background: rgba(255, 215, 0, 0.05);
            border: 1px solid rgba(255, 215, 0, 0.15);
            border-radius: 12px;
        }

        .timer-icon {
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

        .timer-content h5 {
            font-size: 13px;
            font-weight: 700;
            color: var(--gold);
            margin-bottom: 2px;
        }

        .timer-content p {
            font-size: 11px;
            color: var(--silver-dark);
            line-height: 1.4;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .verify-container {
                padding: 36px 28px;
            }

            .verify-header h1 {
                font-size: 24px;
            }

            .otp-input {
                font-size: 28px;
                letter-spacing: 8px;
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

        /* OTP Input Animation */
        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        .otp-input.shake {
            animation: shake 0.5s ease;
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

    <div class="verify-wrapper">
        <div class="grid-overlay"></div>
        
        <div class="verify-container">
            <!-- Logo -->
            <div class="logo-wrapper">
                <img alt="Logo" src="{{ $appConfig['app_logo']['value'] }}" />
            </div>

            <!-- Header -->
            <div class="verify-header">
                <h1>Verify OTP</h1>
                <p>
                    Enter the OTP code sent to<br>
                    <strong>{{ session('email') }}</strong>
                </p>
            </div>

            <!-- Verify OTP Form -->
            <form class="form" method="POST" action="{{ route('verify-otp.post') }}">
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

                <!-- OTP Input -->
                <div class="form-group">
                    <input 
                        type="text" 
                        placeholder="Enter 6-digit OTP" 
                        name="otp"
                        id="otpInput"
                        autocomplete="off" 
                        maxlength="6" 
                        pattern="[0-9]{6}"
                        class="otp-input @error('otp') is-invalid @enderror"
                        required 
                    />
                    @error('otp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <span>Verify OTP</span>
                </button>

                <!-- Resend Link -->
                <div class="resend-link">
                    Didn't receive the code?
                    <a href="{{ route('forget-password') }}">Resend</a>
                </div>
            </form>

            <!-- Timer Badge -->
            <div class="timer-badge">
                <div class="timer-icon">
                    <i class="ki-duotone ki-timer">
                        <span class="path1"></span>
                        <span class="path2"></span>
                        <span class="path3"></span>
                    </i>
                </div>
                <div class="timer-content">
                    <h5>OTP Valid for 10 Minutes</h5>
                    <p>Please verify your OTP code before it expires for security purposes.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        var hostUrl = "assets/";

        // OTP Input auto-format and validation
        const otpInput = document.getElementById('otpInput');
        
        otpInput.addEventListener('input', function(e) {
            // Only allow numbers
            this.value = this.value.replace(/[^0-9]/g, '');
            
            // Auto submit when 6 digits entered (optional)
            if (this.value.length === 6) {
                this.classList.add('success-pulse');
            }
        });

        otpInput.addEventListener('keypress', function(e) {
            // Only allow numbers
            if (e.key < '0' || e.key > '9') {
                e.preventDefault();
            }
        });

        // Form submit animation
        document.querySelector('form').addEventListener('submit', function(e) {
            const btn = document.querySelector('.btn-submit');
            const input = document.getElementById('otpInput');
            
            if (input.value.length !== 6) {
                e.preventDefault();
                input.classList.add('shake');
                setTimeout(() => input.classList.remove('shake'), 500);
                return;
            }
            
            btn.classList.add('loading');
            btn.querySelector('span').textContent = 'Verifying...';
        });

        // Focus on load
        window.addEventListener('load', function() {
            otpInput.focus();
        });
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
</body>

</html>