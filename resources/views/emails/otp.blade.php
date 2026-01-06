<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode OTP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }

        .container {
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2c3e50;
            margin: 0;
        }

        .otp-box {
            background-color: #fff;
            border: 2px dashed #3498db;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 30px 0;
        }

        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #3498db;
            letter-spacing: 8px;
            margin: 10px 0;
        }

        .info {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            <p>Reset Password - Verifikasi OTP</p>
        </div>

        @if ($userName)
            <p>Halo <strong>{{ $userName }}</strong>,</p>
        @else
            <p>Halo,</p>
        @endif

        <p>Anda menerima email ini karena kami menerima permintaan reset password untuk akun Anda.</p>

        <div class="otp-box">
            <p style="margin: 0; color: #7f8c8d;">Kode OTP Anda:</p>
            <div class="otp-code">{{ $otpCode }}</div>
            <p style="margin: 0; color: #7f8c8d; font-size: 14px;">Berlaku selama 5 menit</p>
        </div>

        <div class="info">
            <strong>⚠️ Perhatian:</strong>
            <ul style="margin: 10px 0;">
                <li>Jangan bagikan kode OTP ini kepada siapapun</li>
                <li>Kode akan kedaluwarsa dalam 5 menit</li>
                <li>Kode hanya bisa digunakan 1 kali</li>
            </ul>
        </div>

        <p>Jika Anda tidak melakukan permintaan reset password, abaikan email ini. Password Anda tidak akan berubah.</p>

        <div class="footer">
            <p>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
