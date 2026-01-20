@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <!-- Tab Navigation -->
            <div class="tab-navigation">
                <button class="tab-btn active" data-tab="digital">Digital Currency</button>
                <button class="tab-btn" data-tab="forex">Forex</button>
                <button class="tab-btn" data-tab="precious">Precious metals</button>
            </div>

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
            {{-- <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Balance</p>
                        <h3 class="text-gold mb-0 fw-bold">{{ number_format($userBalance, 2) }} USDT</h3>
                    </div>
                    <div class="balance-icon-wrapper">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
            </div> --}}

            {{-- <!-- Card 2: Referral Code & Link -->
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
            </div> --}}

            <!-- Card 3: Market Overview with Real-Time Prices -->
            <div class="card-dark shadow-sm p-0 mb-3 mt-5">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="text-white mb-0">Market Overview</h6>
                        <span class="market-status-badge active">
                            <i class="bi bi-circle-fill me-1"></i>Live
                        </span>
                    </div>
                </div>

                <!-- Market Item 1: BTC/USDT -->
                <div class="market-coin-item">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="coin-icon btc">
                                <i class="bi bi-currency-bitcoin"></i>
                            </div>
                            <div>
                                <div class="text-white fw-bold mb-1" style="font-size: 14px;">BTC/USDT</div>
                                <small class="text-muted">Bitcoin</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">
                                ${{ $cryptoPrices['BTCUSDT']['price'] ?? '0.00' }}
                            </div>
                            <small
                                class="price-change {{ $cryptoPrices['BTCUSDT']['isPositive'] ? 'positive' : 'negative' }}">
                                @if ($cryptoPrices['BTCUSDT']['isPositive'])
                                    <i class="bi bi-arrow-up"></i>
                                @else
                                    <i class="bi bi-arrow-down"></i>
                                @endif
                                {{ $cryptoPrices['BTCUSDT']['change'] }}%
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Market Item 2: ETH/USDT -->
                <div class="market-coin-item">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="coin-icon eth">
                                <i class="bi bi-currency-exchange"></i>
                            </div>
                            <div>
                                <div class="text-white fw-bold mb-1" style="font-size: 14px;">ETH/USDT</div>
                                <small class="text-muted">Ethereum</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">
                                ${{ $cryptoPrices['ETHUSDT']['price'] ?? '0.00' }}
                            </div>
                            <small
                                class="price-change {{ $cryptoPrices['ETHUSDT']['isPositive'] ? 'positive' : 'negative' }}">
                                @if ($cryptoPrices['ETHUSDT']['isPositive'])
                                    <i class="bi bi-arrow-up"></i>
                                @else
                                    <i class="bi bi-arrow-down"></i>
                                @endif
                                {{ $cryptoPrices['ETHUSDT']['change'] }}%
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Market Item 3: DOGE/USDT -->
                <div class="market-coin-item">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="coin-icon doge">
                                <i class="bi bi-coin"></i>
                            </div>
                            <div>
                                <div class="text-white fw-bold mb-1" style="font-size: 14px;">DOGE/USDT</div>
                                <small class="text-muted">Dogecoin</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">
                                ${{ $cryptoPrices['DOGEUSDT']['price'] ?? '0.00' }}
                            </div>
                            <small
                                class="price-change {{ $cryptoPrices['DOGEUSDT']['isPositive'] ? 'positive' : 'negative' }}">
                                @if ($cryptoPrices['DOGEUSDT']['isPositive'])
                                    <i class="bi bi-arrow-up"></i>
                                @else
                                    <i class="bi bi-arrow-down"></i>
                                @endif
                                {{ $cryptoPrices['DOGEUSDT']['change'] }}%
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Market Item 4: BNB/USDT -->
                <div class="market-coin-item">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="coin-icon bnb">
                                <i class="bi bi-triangle-fill"></i>
                            </div>
                            <div>
                                <div class="text-white fw-bold mb-1" style="font-size: 14px;">BNB/USDT</div>
                                <small class="text-muted">Binance Coin</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">
                                ${{ $cryptoPrices['BNBUSDT']['price'] ?? '0.00' }}
                            </div>
                            <small
                                class="price-change {{ $cryptoPrices['BNBUSDT']['isPositive'] ? 'positive' : 'negative' }}">
                                @if ($cryptoPrices['BNBUSDT']['isPositive'])
                                    <i class="bi bi-arrow-up"></i>
                                @else
                                    <i class="bi bi-arrow-down"></i>
                                @endif
                                {{ $cryptoPrices['BNBUSDT']['change'] }}%
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Market Item 5: SOL/USDT -->
                <div class="market-coin-item" style="border-bottom: none;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="coin-icon sol">
                                <i class="bi bi-sun-fill"></i>
                            </div>
                            <div>
                                <div class="text-white fw-bold mb-1" style="font-size: 14px;">SOL/USDT</div>
                                <small class="text-muted">Solana</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">
                                ${{ $cryptoPrices['SOLUSDT']['price'] ?? '0.00' }}
                            </div>
                            <small
                                class="price-change {{ $cryptoPrices['SOLUSDT']['isPositive'] ? 'positive' : 'negative' }}">
                                @if ($cryptoPrices['SOLUSDT']['isPositive'])
                                    <i class="bi bi-arrow-up"></i>
                                @else
                                    <i class="bi bi-arrow-down"></i>
                                @endif
                                {{ $cryptoPrices['SOLUSDT']['change'] }}%
                            </small>
                        </div>
                    </div>
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

        .price-change {
            display: inline-flex;
            align-items: center;
            gap: 2px;
        }

        .price-change.positive {
            color: #22c55e;
        }

        .price-change.negative {
            color: #ef4444;
        }
    </style>

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
