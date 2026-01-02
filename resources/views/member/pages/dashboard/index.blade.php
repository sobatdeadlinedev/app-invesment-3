@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <h5 class="text-white mb-3">Halo, {{ $user->username }}</h5>
            <!-- Announcement Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-megaphone-fill text-gold" style="font-size: 18px; margin-top: 2px;"></i>
                    <div>
                        <h6 class="text-white mb-1" style="font-size: 13px;">Pengumuman (if exist)</h6>
                        <p class="small text-muted mb-0" style="font-size: 12px;">
                            Platform akan menjalani maintenance pada Minggu, 29 Desember 2024 pukul 01:00 - 03:00 WIB.
                            Terima kasih atas pengertiannya.
                        </p>
                    </div>
                </div>
            </div>
            <!-- Card 1: Balance -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Total Balance</p>
                        <h3 class="text-gold mb-0 fw-bold">$ 15,250.00</h3>
                    </div>
                    <div class="balance-icon-wrapper">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
            </div>

            <!-- Card 2: Referral Code -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <div class="referral-icon-small">
                            <i class="bi bi-gift-fill"></i>
                        </div>
                        <p class="text-muted mb-0 small">Kode Referral</p>
                    </div>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <div class="referral-code-display" id="referralCode">{{ $user->refferal_code }}</div>
                    <button class="btn-copy-small" onclick="copyReferralCode()" title="Copy">
                        <i class="bi bi-clipboard" id="copyIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Card 3: Market Overview -->
            <div class="card-dark shadow-sm p-0 mb-3">
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
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">$43,250.50</div>
                            <small class="price-change positive">+2.45%</small>
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
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">$2,320.75</div>
                            <small class="price-change positive">+1.83%</small>
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
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">$0.0825</div>
                            <small class="price-change negative">-0.52%</small>
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
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">$315.40</div>
                            <small class="price-change positive">+3.12%</small>
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
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">$98.65</div>
                            <small class="price-change positive">+5.27%</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyReferralCode() {
            const codeElement = document.getElementById('referralCode');
            const code = codeElement.textContent;
            const icon = document.getElementById('copyIcon');

            navigator.clipboard.writeText(code).then(() => {
                // Ubah icon jadi check
                icon.classList.remove('bi-clipboard');
                icon.classList.add('bi-check-lg');

                // Tampilkan notifikasi
                // Bisa pakai toast atau alert
                const toast = document.createElement('div');
                toast.style.cssText =
                    'position: fixed; top: 20px; right: 20px; background: #28a745; color: white; padding: 12px 20px; border-radius: 8px; z-index: 9999; font-size: 14px;';
                toast.textContent = 'Kode referral berhasil disalin!';
                document.body.appendChild(toast);

                // Hapus notifikasi setelah 2 detik
                setTimeout(() => {
                    toast.remove();
                    // Kembalikan icon ke clipboard
                    icon.classList.remove('bi-check-lg');
                    icon.classList.add('bi-clipboard');
                }, 2000);
            }).catch(err => {
                alert('Gagal menyalin kode referral');
                console.error('Error copying:', err);
            });
        }
    </script>
@endsection
