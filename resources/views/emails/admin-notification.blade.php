<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #3498db;
        }

        .header h1 {
            color: #2c3e50;
            margin: 0 0 10px 0;
        }

        .badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            color: #fff;
        }

        .badge-deposit {
            background-color: #27ae60;
        }

        .badge-withdrawal {
            background-color: #e67e22;
        }

        .badge-verification {
            background-color: #3498db;
        }

        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .info-row {
            display: flex;
            margin-bottom: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #e0e0e0;
        }

        .info-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-label {
            font-weight: bold;
            color: #555;
            min-width: 150px;
        }

        .info-value {
            color: #333;
            flex: 1;
        }

        .amount {
            font-size: 28px;
            font-weight: bold;
            color: #27ae60;
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background-color: #e8f8f5;
            border-radius: 8px;
        }

        .action-button {
            display: block;
            width: 100%;
            padding: 15px;
            margin: 20px 0;
            text-align: center;
            background-color: #3498db;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
        }

        .action-button:hover {
            background-color: #2980b9;
        }

        .alert {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #e0e0e0;
            font-size: 12px;
            color: #7f8c8d;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ config('app.name') }}</h1>
            @if ($type === 'deposit')
                <span class="badge badge-deposit">DEPOSIT BARU</span>
            @elseif($type === 'withdrawal')
                <span class="badge badge-withdrawal">WITHDRAWAL BARU</span>
            @else
                <span class="badge badge-verification">VERIFIKASI BARU</span>
            @endif
        </div>

        <p><strong>Halo Admin,</strong></p>

        @if ($type === 'deposit')
            <p>Ada permintaan deposit baru yang memerlukan persetujuan Anda.</p>

            <div class="info-box">
                <div class="info-row">
                    <div class="info-label">Nama User:</div>
                    <div class="info-value">{{ $userName }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $userEmail }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Reference:</div>
                    <div class="info-value"><strong>{{ $data['reference'] }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Metode Pembayaran:</div>
                    <div class="info-value">{{ $data['payment_method'] === 'ewallet' ? 'E-Wallet' : 'QR Code' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Waktu Request:</div>
                    <div class="info-value">{{ $data['created_at'] }}</div>
                </div>
            </div>

            <div class="amount">
                {{ number_format($data['amount'], 2) }} USDT
            </div>
        @elseif($type === 'withdrawal')
            <p>Ada permintaan withdrawal baru yang memerlukan persetujuan Anda.</p>

            <div class="info-box">
                <div class="info-row">
                    <div class="info-label">Nama User:</div>
                    <div class="info-value">{{ $userName }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $userEmail }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Reference:</div>
                    <div class="info-value"><strong>{{ $data['reference'] }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Wallet Address:</div>
                    <div class="info-value">{{ $data['wallet_address'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Network:</div>
                    <div class="info-value">{{ $data['network'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Fee Withdrawal:</div>
                    <div class="info-value">{{ number_format($data['fee'], 2) }} USDT</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Waktu Request:</div>
                    <div class="info-value">{{ $data['created_at'] }}</div>
                </div>
            </div>

            <div class="amount">
                User akan terima: {{ number_format($data['net_amount'], 2) }} USDT
            </div>
        @else
            <p>Ada permintaan verifikasi akun baru yang memerlukan review Anda.</p>

            <div class="info-box">
                <div class="info-row">
                    <div class="info-label">Nama User:</div>
                    <div class="info-value">{{ $userName }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $userEmail }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nama Lengkap (KTP):</div>
                    <div class="info-value">{{ $data['full_name'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jenis Identitas:</div>
                    <div class="info-value">{{ $data['identity_type'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nomor Identitas:</div>
                    <div class="info-value">{{ $data['identity_number'] }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Waktu Submit:</div>
                    <div class="info-value">{{ $data['submitted_at'] }}</div>
                </div>
            </div>
        @endif

        <div class="alert">
            <strong>⚠️ Tindakan Diperlukan:</strong><br>
            Silakan login ke dashboard admin untuk mereview dan menyetujui permintaan ini.
        </div>

        <a href="{{ url('/admin/dashboard') }}" class="action-button">
            Buka Dashboard Admin
        </a>

        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
