@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <h5 class="text-white mb-3">Halo, {{ $user->username }}</h5>

            @if ($announcement && !empty($announcement))
                <!-- Announcement Card -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-megaphone-fill text-gold" style="font-size: 18px; margin-top: 2px;"></i>
                        <div>
                            <h6 class="text-white mb-1" style="font-size: 13px;">Pengumuman</h6>
                            <p class="small text-muted mb-0" style="font-size: 12px;">
                                {{ $announcement }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Card 1: Balance -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Balance</p>
                        <h3 class="text-gold mb-0 fw-bold">{{ number_format($userBalance, 2) }} USDT</h3>
                    </div>
                    <div class="balance-icon-wrapper">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
            </div>

            <!-- Card 2: Referral Code & Link -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="referral-icon-small">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                        <p class="text-muted mb-0 small">Kode Referral</p>
                    </div>
                </div>

                <!-- Referral Code -->
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="referral-code-display" id="referralCode">{{ $user->refferal_code }}</div>
                    <button class="btn-copy-small" onclick="copyReferralCode()" title="Copy Kode">
                        <i class="bi bi-clipboard" id="copyCodeIcon"></i>
                    </button>
                </div>

                <!-- Referral Link -->
                <div>
                    <p class="text-muted mb-2 small">Link Referral</p>
                    <div class="d-flex align-items-center justify-content-between gap-2">
                        <div class="referral-link-display" id="referralLink">{{ $referralLink }}</div>
                        <button class="btn-copy-small" onclick="copyReferralLink()" title="Copy Link">
                            <i class="bi bi-link-45deg" id="copyLinkIcon"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 3: Market Overview with Real-Time Data -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="text-white mb-0">Market Overview</h6>
                        <span class="market-status-badge active">
                            <i class="bi bi-circle-fill me-1"></i>Live
                        </span>
                    </div>
                </div>

                <!-- TradingView Widget Container -->
                <div class="tradingview-widget-container" style="background: transparent;">
                    <div class="tradingview-widget-container__widget"></div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .referral-link-display {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 10px 12px;
            color: var(--text-muted);
            font-size: 11px;
            font-family: monospace;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
        }

        .tradingview-widget-container {
            height: auto;
        }
    </style>

    <!-- TradingView Widget Script -->
    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js"
        async>
        {
            "symbols": [
                ["BINANCE:BTCUSDT|1D"],
                ["BINANCE:ETHUSDT|1D"],
                ["BINANCE:DOGEUSDT|1D"],
                ["BINANCE:BNBUSDT|1D"],
                ["BINANCE:SOLUSDT|1D"]
            ],
            "chartOnly": false,
            "width": "100%",
            "height": "400",
            "locale": "en",
            "colorTheme": "dark",
            "autosize": false,
            "showVolume": false,
            "showMA": false,
            "hideDateRanges": false,
            "hideMarketStatus": false,
            "hideSymbolLogo": false,
            "scalePosition": "right",
            "scaleMode": "Normal",
            "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
            "fontSize": "10",
            "noTimeScale": false,
            "valuesTracking": "1",
            "changeMode": "price-and-percent",
            "chartType": "area",
            "backgroundColor": "rgba(10, 14, 39, 1)",
            "gridLineColor": "rgba(29, 32, 88, 0.3)",
            "lineColor": "rgba(245, 166, 35, 1)",
            "topColor": "rgba(245, 166, 35, 0.4)",
            "bottomColor": "rgba(245, 166, 35, 0.0)",
            "lineWidth": 2
        }
    </script>

    <script>
        function showToast(message, type = 'success') {
            const bgColor = type === 'success' ? '#28a745' : '#dc3545';
            const toast = document.createElement('div');
            toast.style.cssText = `
                position: fixed; 
                top: 20px; 
                right: 20px; 
                background: ${bgColor}; 
                color: white; 
                padding: 12px 20px; 
                border-radius: 8px; 
                z-index: 9999; 
                font-size: 14px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            `;
            toast.textContent = message;
            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 2000);
        }

        function copyReferralCode() {
            const codeElement = document.getElementById('referralCode');
            const code = codeElement.textContent;
            const icon = document.getElementById('copyCodeIcon');

            navigator.clipboard.writeText(code).then(() => {
                icon.classList.remove('bi-clipboard');
                icon.classList.add('bi-check-lg');
                showToast('Kode referral berhasil disalin!');
                setTimeout(() => {
                    icon.classList.remove('bi-check-lg');
                    icon.classList.add('bi-clipboard');
                }, 2000);
            }).catch(err => {
                showToast('Gagal menyalin kode referral', 'error');
                console.error('Error copying:', err);
            });
        }

        function copyReferralLink() {
            const linkElement = document.getElementById('referralLink');
            const link = linkElement.textContent;
            const icon = document.getElementById('copyLinkIcon');

            navigator.clipboard.writeText(link).then(() => {
                icon.classList.remove('bi-link-45deg');
                icon.classList.add('bi-check-lg');
                showToast('Link referral berhasil disalin!');
                setTimeout(() => {
                    icon.classList.remove('bi-check-lg');
                    icon.classList.add('bi-link-45deg');
                }, 2000);
            }).catch(err => {
                showToast('Gagal menyalin link referral', 'error');
                console.error('Error copying:', err);
            });
        }
    </script>
@endsection
