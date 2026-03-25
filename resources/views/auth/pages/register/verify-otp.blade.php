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
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <style>
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --gold: #F5C842;
            --gold-dim: #C9A227;
            --gold-muted: rgba(245,200,66,0.1);
            --gold-border: rgba(245,200,66,0.25);
            --bg: #080B10;
            --bg-input: #111620;
            --border: rgba(255,255,255,0.07);
            --text-primary: #F0F4F8;
            --text-secondary: #6B7A8D;
            --text-muted: #3D4A58;
            --red: #F04F59;
            --red-dim: rgba(240,79,89,0.1);
            --green: #16A879;
            --green-dim: rgba(22,168,121,0.1);
            --mono: 'JetBrains Mono', monospace;
            --sans: 'Space Grotesk', sans-serif;
        }

        html { background: var(--bg); }
        body {
            font-family: var(--sans);
            background: var(--bg);
            color: var(--text-primary);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* Background */
        .bg-canvas { position: fixed; inset: 0; z-index: 0; overflow: hidden; }
        .bg-grid {
            position: absolute; inset: 0;
            background-image:
                linear-gradient(rgba(245,200,66,0.025) 1px, transparent 1px),
                linear-gradient(90deg, rgba(245,200,66,0.025) 1px, transparent 1px);
            background-size: 48px 48px;
        }
        .bg-glow {
            position: absolute; top: -20%; left: 50%; transform: translateX(-50%);
            width: 70vw; height: 50vw; border-radius: 50%;
            background: radial-gradient(circle, rgba(245,200,66,0.06) 0%, transparent 65%);
            animation: glow 14s ease-in-out infinite;
        }
        @keyframes glow {
            0%, 100% { opacity: 0.7; transform: translateX(-50%) scale(1); }
            50% { opacity: 1; transform: translateX(-50%) scale(1.12); }
        }

        /* Ticker */
        .ticker-bar {
            position: fixed; top: 0; left: 0; right: 0; z-index: 100;
            height: 36px; background: rgba(8,11,16,0.95);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; overflow: hidden;
            backdrop-filter: blur(10px);
        }
        .ticker-label {
            flex-shrink: 0; padding: 0 16px;
            font-family: var(--mono); font-size: 9px; font-weight: 700;
            letter-spacing: 2px; color: var(--gold);
            border-right: 1px solid var(--border);
            height: 100%; display: flex; align-items: center;
            background: rgba(245,200,66,0.05);
        }
        .ticker-scroll { display: flex; overflow: hidden; flex: 1; }
        .ticker-track { display: flex; animation: ticker 28s linear infinite; white-space: nowrap; }
        .ticker-item {
            display: flex; align-items: center; gap: 8px;
            padding: 0 24px; font-family: var(--mono); font-size: 10px;
            border-right: 1px solid var(--border); height: 36px;
        }
        .ticker-sym { color: var(--text-secondary); font-weight: 500; }
        .ticker-price { color: var(--text-primary); font-weight: 700; }
        .ticker-chg.up { color: var(--green); }
        .ticker-chg.dn { color: var(--red); }
        @keyframes ticker { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

        /* Layout */
        .page-wrap {
            min-height: 100vh; padding-top: 36px;
            display: flex; align-items: center; justify-content: center;
            position: relative; z-index: 1;
            padding: 36px 20px 40px;
        }

        .verify-box {
            width: 100%; max-width: 480px;
            animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Brand */
        .top-brand {
            display: flex; flex-direction: column; align-items: center;
            gap: 10px; margin-bottom: 32px;
        }
        .top-brand img {
            width: 52px; height: 52px; object-fit: contain;
            filter: drop-shadow(0 0 14px rgba(245,200,66,0.4));
        }
        .top-brand-name {
            font-family: var(--mono); font-size: 9px; font-weight: 700;
            letter-spacing: 3px; text-transform: uppercase; color: var(--gold);
        }

        /* Steps */
        .steps {
            display: flex; align-items: center; justify-content: center; margin-bottom: 36px;
        }
        .step { display: flex; flex-direction: column; align-items: center; gap: 6px; }
        .step-circle {
            width: 30px; height: 30px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: var(--mono); font-size: 11px; font-weight: 700;
        }
        .step.done .step-circle {
            background: rgba(22,168,121,0.15); border: 2px solid var(--green); color: var(--green);
        }
        .step.active .step-circle {
            background: var(--gold); border: 2px solid var(--gold); color: #080B10;
        }
        .step.pending .step-circle {
            background: transparent; border: 2px solid rgba(255,255,255,0.1); color: var(--text-muted);
        }
        .step-lbl { font-size: 9px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; }
        .step.done .step-lbl { color: var(--green); }
        .step.active .step-lbl { color: var(--gold); }
        .step.pending .step-lbl { color: var(--text-muted); }
        .step-line {
            flex: 1; height: 1px; max-width: 56px; margin: 0 8px; margin-bottom: 18px;
            background: rgba(255,255,255,0.08);
        }
        .step-line.done { background: var(--green); }

        /* Header */
        .form-head { text-align: center; margin-bottom: 32px; }
        .form-head h1 {
            font-size: 22px; font-weight: 700; color: var(--text-primary);
            letter-spacing: -0.3px; margin-bottom: 8px;
        }
        .form-head p { font-size: 13px; color: var(--text-secondary); line-height: 1.6; }
        .form-head strong { color: var(--gold); font-weight: 600; }

        /* Alerts */
        .alert {
            display: flex; gap: 10px; align-items: flex-start;
            border-radius: 10px; padding: 13px 16px; margin-bottom: 20px;
            font-size: 13px;
            animation: slideDown 0.3s ease-out;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .alert-success {
            background: var(--green-dim); border: 1px solid rgba(22,168,121,0.2);
            border-left: 3px solid var(--green); color: #6ee7b7;
        }
        .alert-success i { color: var(--green); font-size: 17px; flex-shrink: 0; }
        .alert-danger {
            background: var(--red-dim); border: 1px solid rgba(240,79,89,0.2);
            border-left: 3px solid var(--red); color: #fca5a5;
        }
        .alert-danger i { color: var(--red); font-size: 17px; flex-shrink: 0; }

        /* OTP Digits */
        .otp-row {
            display: flex; gap: 10px; justify-content: center;
            margin-bottom: 28px;
        }

        .otp-box {
            width: 58px; height: 68px;
            background: var(--bg-input);
            border: 2px solid var(--border);
            border-radius: 12px;
            font-size: 28px; font-weight: 700;
            font-family: var(--mono);
            color: var(--gold);
            text-align: center;
            outline: none; caret-color: var(--gold);
            transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s, background 0.2s;
        }

        .otp-box:focus {
            border-color: var(--gold);
            background: rgba(245,200,66,0.05);
            box-shadow: 0 0 0 3px rgba(245,200,66,0.1);
            transform: translateY(-3px);
        }

        .otp-box.filled {
            border-color: rgba(245,200,66,0.4);
            background: rgba(245,200,66,0.04);
        }

        .otp-box.is-invalid { border-color: var(--red) !important; }

        .otp-row.shake .otp-box {
            animation: shake 0.45s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            15%, 55% { transform: translateX(-5px); }
            35%, 75% { transform: translateX(5px); }
        }

        .otp-error {
            text-align: center; font-size: 12px;
            color: #fca5a5; margin-top: -18px; margin-bottom: 16px;
        }

        /* Submit */
        .btn-verify {
            width: 100%; height: 52px;
            background: var(--gold); border: none; border-radius: 10px;
            font-size: 14px; font-weight: 700; font-family: var(--sans);
            color: #080B10; cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            position: relative; overflow: hidden;
            transition: transform 0.2s, box-shadow 0.2s, opacity 0.2s;
            box-shadow: 0 4px 24px rgba(245,200,66,0.22);
        }
        .btn-verify::after {
            content: ''; position: absolute; inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.15) 0%, transparent 55%);
            pointer-events: none;
        }
        .btn-verify:hover { transform: translateY(-2px); box-shadow: 0 8px 32px rgba(245,200,66,0.3); }
        .btn-verify:active { transform: translateY(0); }
        .btn-verify:disabled { opacity: 0.35; cursor: not-allowed; transform: none; }
        .btn-verify.loading { pointer-events: none; opacity: 0.7; }
        .spinner {
            display: none; width: 16px; height: 16px;
            border: 2px solid rgba(0,0,0,0.25); border-top-color: #080B10;
            border-radius: 50%; animation: spin 0.7s linear infinite;
        }
        .btn-verify.loading .spinner { display: block; }
        @keyframes spin { to { transform: rotate(360deg); } }

        /* Resend */
        .resend-row {
            text-align: center; margin-top: 24px; padding-top: 20px;
            border-top: 1px solid var(--border);
            font-size: 13px; color: var(--text-secondary);
        }
        .resend-link {
            color: var(--gold); text-decoration: none; font-weight: 600; margin-left: 4px;
            transition: color 0.2s;
        }
        .resend-link:hover { color: #fde68a; }
        .resend-link.disabled { color: var(--text-muted); pointer-events: none; }
        #countdown { color: var(--gold); font-family: var(--mono); font-weight: 700; }

        /* Timer info */
        .timer-info {
            display: flex; gap: 12px; align-items: flex-start;
            margin-top: 20px; padding: 14px 16px;
            background: rgba(245,200,66,0.04);
            border: 1px solid var(--gold-border);
            border-radius: 10px;
        }
        .timer-info-icon {
            flex-shrink: 0; width: 32px; height: 32px;
            display: flex; align-items: center; justify-content: center;
            background: rgba(245,200,66,0.08); border-radius: 8px;
            color: var(--gold); font-size: 15px;
        }
        .timer-info-title { font-size: 12px; font-weight: 700; color: var(--gold); margin-bottom: 3px; }
        .timer-info-msg { font-size: 11px; color: var(--text-secondary); line-height: 1.4; }

        @media (max-width: 480px) {
            .otp-box { width: 46px; height: 56px; font-size: 22px; border-radius: 10px; }
            .otp-row { gap: 8px; }
            .verify-box { padding-top: 8px; }
            .btn-verify { height: 50px; }
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: #1e2533; border-radius: 3px; }
    </style>
    <script>
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>
</head>

<body id="kt_body" class="app-blank">
    <div class="bg-canvas">
        <div class="bg-grid"></div>
        <div class="bg-glow"></div>
    </div>

    <!-- Ticker -->
    <div class="ticker-bar">
        <div class="ticker-label">LIVE</div>
        <div class="ticker-scroll">
            <div class="ticker-track">
                <div class="ticker-item"><span class="ticker-sym">BTC/USDT</span><span class="ticker-price">67,842.30</span><span class="ticker-chg up">+2.34%</span></div>
                <div class="ticker-item"><span class="ticker-sym">ETH/USDT</span><span class="ticker-price">3,521.10</span><span class="ticker-chg up">+1.87%</span></div>
                <div class="ticker-item"><span class="ticker-sym">BNB/USDT</span><span class="ticker-price">612.45</span><span class="ticker-chg dn">-0.52%</span></div>
                <div class="ticker-item"><span class="ticker-sym">SOL/USDT</span><span class="ticker-price">178.90</span><span class="ticker-chg up">+4.21%</span></div>
                <div class="ticker-item"><span class="ticker-sym">XRP/USDT</span><span class="ticker-price">0.6124</span><span class="ticker-chg dn">-1.03%</span></div>
                <div class="ticker-item"><span class="ticker-sym">ADA/USDT</span><span class="ticker-price">0.4832</span><span class="ticker-chg up">+0.78%</span></div>
                <div class="ticker-item"><span class="ticker-sym">BTC/USDT</span><span class="ticker-price">67,842.30</span><span class="ticker-chg up">+2.34%</span></div>
                <div class="ticker-item"><span class="ticker-sym">ETH/USDT</span><span class="ticker-price">3,521.10</span><span class="ticker-chg up">+1.87%</span></div>
                <div class="ticker-item"><span class="ticker-sym">BNB/USDT</span><span class="ticker-price">612.45</span><span class="ticker-chg dn">-0.52%</span></div>
                <div class="ticker-item"><span class="ticker-sym">SOL/USDT</span><span class="ticker-price">178.90</span><span class="ticker-chg up">+4.21%</span></div>
                <div class="ticker-item"><span class="ticker-sym">XRP/USDT</span><span class="ticker-price">0.6124</span><span class="ticker-chg dn">-1.03%</span></div>
                <div class="ticker-item"><span class="ticker-sym">ADA/USDT</span><span class="ticker-price">0.4832</span><span class="ticker-chg up">+0.78%</span></div>
            </div>
        </div>
    </div>

    <div class="page-wrap">
        <div class="verify-box">

            <div class="top-brand">
                <img src="{{ $appConfig['app_logo']['value'] }}" alt="Logo" />
                <div class="top-brand-name">{{ $appConfig['app_name']['value'] }}</div>
            </div>

            <!-- Steps -->
            <div class="steps">
                <div class="step done">
                    <div class="step-circle">
                        <i class="ki-duotone ki-check" style="font-size:13px;">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                    </div>
                    <span class="step-lbl">Register</span>
                </div>
                <div class="step-line done"></div>
                <div class="step active">
                    <div class="step-circle">2</div>
                    <span class="step-lbl">Verify</span>
                </div>
                <div class="step-line"></div>
                <div class="step pending">
                    <div class="step-circle">3</div>
                    <span class="step-lbl">Done</span>
                </div>
            </div>

            <div class="form-head">
                <h1>Verify your email</h1>
                <p>
                    Enter the 6-digit OTP code sent to<br>
                    <strong>{{ session('register_email') }}</strong>
                </p>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="ki-duotone ki-check-circle"><span class="path1"></span><span class="path2"></span></i>
                    <div>{{ session('success') }}</div>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="ki-duotone ki-cross-circle"><span class="path1"></span><span class="path2"></span></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="ki-duotone ki-information">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register.verify-otp.post') }}" id="otpForm">
                @csrf

                <div class="otp-row" id="otpRow">
                    <input class="otp-box @error('otp') is-invalid @enderror" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" />
                    <input class="otp-box @error('otp') is-invalid @enderror" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" />
                    <input class="otp-box @error('otp') is-invalid @enderror" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" />
                    <input class="otp-box @error('otp') is-invalid @enderror" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" />
                    <input class="otp-box @error('otp') is-invalid @enderror" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" />
                    <input class="otp-box @error('otp') is-invalid @enderror" type="text" maxlength="1" inputmode="numeric" pattern="[0-9]" autocomplete="off" />
                </div>

                <input type="hidden" name="otp" id="otpHidden" />

                @error('otp')
                    <div class="otp-error">{{ $message }}</div>
                @enderror

                <button type="submit" class="btn-verify" id="verifyBtn" disabled>
                    <div class="spinner"></div>
                    <span class="btn-text">Verify &amp; Complete Registration</span>
                    <i class="ki-duotone ki-arrow-right" style="font-size:16px;">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                </button>

                <div class="resend-row">
                    Didn't receive the code?
                    <a href="{{ route('register.resend-otp') }}" id="resendLink" class="resend-link disabled">
                        Resend in <span id="countdown">60</span>s
                    </a>
                </div>
            </form>

            <div class="timer-info">
                <div class="timer-info-icon">
                    <i class="ki-duotone ki-timer">
                        <span class="path1"></span><span class="path2"></span><span class="path3"></span>
                    </i>
                </div>
                <div>
                    <div class="timer-info-title">OTP Valid for 10 Minutes</div>
                    <div class="timer-info-msg">Verify before it expires. Check your spam folder if you don't see the email.</div>
                </div>
            </div>

        </div>
    </div>

    <script>
        var hostUrl = "assets/";

        const digits    = document.querySelectorAll('.otp-box');
        const hidden    = document.getElementById('otpHidden');
        const verifyBtn = document.getElementById('verifyBtn');
        const otpRow    = document.getElementById('otpRow');

        function syncHidden() {
            const val = Array.from(digits).map(d => d.value).join('');
            hidden.value = val;
            verifyBtn.disabled = val.length < 6;
            digits.forEach(d => d.classList.toggle('filled', d.value !== ''));
        }

        digits.forEach((digit, idx) => {
            digit.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '').slice(-1);
                if (this.value && idx < digits.length - 1) digits[idx + 1].focus();
                syncHidden();
            });

            digit.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace') {
                    if (!this.value && idx > 0) {
                        digits[idx - 1].value = '';
                        digits[idx - 1].focus();
                    }
                    syncHidden();
                }
                if (e.key === 'ArrowLeft'  && idx > 0) digits[idx - 1].focus();
                if (e.key === 'ArrowRight' && idx < digits.length - 1) digits[idx + 1].focus();
            });

            digit.addEventListener('paste', function (e) {
                e.preventDefault();
                const paste = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
                paste.split('').slice(0, 6).forEach((c, i) => { if (digits[i]) digits[i].value = c; });
                digits[Math.min(paste.length, 5)].focus();
                syncHidden();
            });
        });

        window.addEventListener('load', () => digits[0].focus());

        document.getElementById('otpForm').addEventListener('submit', function (e) {
            syncHidden();
            if (hidden.value.length !== 6) {
                e.preventDefault();
                otpRow.classList.add('shake');
                setTimeout(() => otpRow.classList.remove('shake'), 600);
                return;
            }
            verifyBtn.classList.add('loading');
            verifyBtn.querySelector('.btn-text').textContent = 'Verifying...';
        });

        // Countdown
        const resendLink = document.getElementById('resendLink');
        const countEl    = document.getElementById('countdown');
        let   left       = 60;

        const timer = setInterval(() => {
            left--;
            countEl.textContent = left;
            if (left <= 0) {
                clearInterval(timer);
                resendLink.classList.remove('disabled');
                resendLink.innerHTML = 'Resend OTP';
            }
        }, 1000);
    </script>

    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
</body>
</html>