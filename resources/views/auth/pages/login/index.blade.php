<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ url('/') }}/" />
    <title>STARS INVESMENT</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
    <style>
        :root {
            --primary-color: #3861fb;
            --primary-hover: #2648d8;
            --dark-bg: #0b0e11;
            --card-bg: #161a1e;
            --border-color: #2b3139;
            --text-primary: #ffffff;
            --text-secondary: #848e9c;
        }

        body {
            background: linear-gradient(135deg, #0b0e11 0%, #1a1f26 100%);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }

        .login-container::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(56, 97, 251, 0.15) 0%, transparent 70%);
            top: -100px;
            right: -100px;
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite;
        }

        .login-container::after {
            content: '';
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(56, 97, 251, 0.1) 0%, transparent 70%);
            bottom: -100px;
            left: -100px;
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite 2s;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.8; }
        }

        .login-wrapper {
            display: flex;
            max-width: 1200px;
            width: 100%;
            background: var(--card-bg);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
            position: relative;
            z-index: 1;
        }

        .login-left {
            flex: 1;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right {
            flex: 1;
            background: linear-gradient(135deg, #3861fb 0%, #6c5ce7 100%);
            padding: 60px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-right::before {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            top: -100px;
            right: -100px;
        }

        .login-right::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            bottom: -50px;
            left: -50px;
        }

        .brand-logo {
            margin-bottom: 40px;
        }

        .brand-logo img {
            max-width: 180px;
            height: auto;
            filter: brightness(1.2);
        }

        .login-title {
            color: var(--text-primary);
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .login-subtitle {
            color: var(--text-secondary);
            font-size: 15px;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-label {
            display: block;
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 14px 16px;
            background: var(--dark-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-primary);
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(56, 97, 251, 0.1);
        }

        .form-input::placeholder {
            color: var(--text-secondary);
        }

        .form-input.is-invalid {
            border-color: #f6465d;
        }

        .invalid-feedback {
            color: #f6465d;
            font-size: 13px;
            margin-top: 6px;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 8px;
            margin-bottom: 24px;
            background: rgba(246, 70, 93, 0.1);
            border: 1px solid rgba(246, 70, 93, 0.3);
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
            color: #f6465d;
            font-size: 14px;
        }

        .forgot-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: var(--primary-hover);
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: var(--primary-color);
            border: none;
            border-radius: 8px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 24px;
        }

        .btn-login:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(56, 97, 251, 0.3);
        }

        .signup-text {
            text-align: center;
            margin-top: 24px;
            color: var(--text-secondary);
            font-size: 14px;
        }

        .signup-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            margin-left: 4px;
        }

        .signup-link:hover {
            color: var(--primary-hover);
        }

        .right-content {
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .right-logo {
            margin-bottom: 30px;
        }

        .right-logo img {
            max-width: 200px;
            height: auto;
        }

        .right-title {
            color: white;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .right-description {
            color: rgba(255, 255, 255, 0.9);
            font-size: 16px;
            line-height: 1.6;
            max-width: 400px;
        }

        .features {
            margin-top: 40px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            color: white;
            font-size: 15px;
        }

        .feature-icon {
            width: 24px;
            height: 24px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        @media (max-width: 992px) {
            .login-wrapper {
                flex-direction: column;
            }

            .login-right {
                order: -1;
                padding: 40px 30px;
            }

            .login-left {
                padding: 40px 30px;
            }

            .right-title {
                font-size: 24px;
            }

            .right-description {
                font-size: 14px;
            }

            .features {
                margin-top: 30px;
            }
        }

        @media (max-width: 576px) {
            .login-container {
                padding: 0;
            }

            .login-wrapper {
                border-radius: 0;
            }

            .login-left {
                padding: 30px 20px;
            }

            .login-right {
                padding: 30px 20px;
            }

            .login-title {
                font-size: 26px;
            }

            .right-title {
                font-size: 22px;
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
        <div class="login-wrapper">
            <div class="login-left">
                <div class="brand-logo">
                    <img alt="Logo" src="{{ $appConfig['app_logo']['value'] }}" />
                </div>

                <h1 class="login-title">Welcome Back</h1>
                <p class="login-subtitle">Sign in to continue to your account</p>

                <form class="form w-100" method="POST" action="{{ route('login.post') }}">
                    @csrf

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label class="form-label">Username or Phone Number</label>
                        <input type="text" placeholder="Enter your username or phone" name="login"
                            autocomplete="off" value="{{ old('login') }}"
                            class="form-input @error('login') is-invalid @enderror" required />
                        @error('login')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <input type="password" placeholder="Enter your password" name="password" autocomplete="off"
                            class="form-input @error('password') is-invalid @enderror" required />
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div style="text-align: right; margin-bottom: 10px;">
                        <a href="{{ route('forget-password') }}" class="forgot-link">
                            Forgot Password?
                        </a>
                    </div>

                    <button type="submit" class="btn-login">
                        <span class="indicator-label">Sign In</span>
                    </button>

                    <div class="signup-text">
                        Don't have an account?
                        <a href="{{ route('register') }}" class="signup-link">Sign Up</a>
                    </div>
                </form>
            </div>

            <div class="login-right">
                <div class="right-content">
                    <div class="right-logo">
                        <img alt="Logo" src="{{ $appConfig['app_logo']['value'] }}" />
                    </div>
                    <h2 class="right-title">Start Trading Today</h2>
                    <p class="right-description">
                        Join millions of traders worldwide. Trade cryptocurrencies with confidence on our secure platform.
                    </p>
                    <div class="features">
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <span>Secure & Reliable Platform</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <span>24/7 Customer Support</span>
                        </div>
                        <div class="feature-item">
                            <div class="feature-icon">✓</div>
                            <span>Low Trading Fees</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var hostUrl = "assets/";
    </script>
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
</body>

</html>