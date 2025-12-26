@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <!-- Greeting -->
            <div class="mb-3">
                <h5 class="text-white mb-1">Halo, John Doe 👋</h5>
                <p class="text-muted small mb-0">Selamat datang kembali di dashboard Anda</p>
            </div>

            <!-- Card 1: Balance Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <p class="text-muted mb-1 small">Total Balance</p>
                        <h3 class="text-gold mb-0 fw-bold">$ 15,250.00</h3>
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <div>
                                <small class="text-muted d-block" style="font-size: 11px;">Available</small>
                                <small class="text-white fw-bold">$ 8,120.00</small>
                            </div>
                            <div style="width: 1px; height: 20px; background: var(--border-color);"></div>
                            <div>
                                <small class="text-muted d-block" style="font-size: 11px;">Locked</small>
                                <small class="text-white fw-bold">$ 7,130.00</small>
                            </div>
                        </div>
                    </div>
                    <div class="balance-icon-wrapper">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <button class="btn btn-gold w-100 btn-sm">
                            <i class="bi bi-plus-circle me-1"></i>Deposit
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-outline-gold w-100 btn-sm">
                            <i class="bi bi-arrow-up-circle me-1"></i>Withdraw
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card 2: Quick Stats (3 cards in row) -->
            <div class="row g-2 mb-3">
                <!-- Total Investment -->
                <div class="col-4">
                    <div class="card-dark shadow-sm p-2 text-center">
                        <div class="mb-1"
                            style="height: 32px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-graph-up-arrow text-gold" style="font-size: 24px;"></i>
                        </div>
                        <p class="text-muted mb-1" style="font-size: 10px;">Investment</p>
                        <h6 class="text-white mb-0 fw-bold" style="font-size: 13px;">$ 7,130</h6>
                    </div>
                </div>

                <!-- Monthly Profit -->
                <div class="col-4">
                    <div class="card-dark shadow-sm p-2 text-center">
                        <div class="mb-1"
                            style="height: 32px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-trophy text-gold" style="font-size: 24px;"></i>
                        </div>
                        <p class="text-muted mb-1" style="font-size: 10px;">Profit</p>
                        <h6 class="text-white mb-0 fw-bold" style="font-size: 13px;">$ 2,450</h6>
                    </div>
                </div>

                <!-- Team Earnings -->
                <div class="col-4">
                    <div class="card-dark shadow-sm p-2 text-center">
                        <div class="mb-1"
                            style="height: 32px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-people text-gold" style="font-size: 24px;"></i>
                        </div>
                        <p class="text-muted mb-1" style="font-size: 10px;">Team</p>
                        <h6 class="text-white mb-0 fw-bold" style="font-size: 13px;">$ 1,820</h6>
                    </div>
                </div>
            </div>

            <!-- Card 3: Active Investments -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="text-white mb-0">Active Investments</h6>
                        <span class="badge-count">3 Paket</span>
                    </div>
                </div>

                <!-- Investment Item 1 -->
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">Bitcoin Package</div>
                            <small class="text-muted">$ 3,000 • ROI 15% / bulan</small>
                        </div>
                        <span class="text-gold fw-bold" style="font-size: 14px;">$ 450</span>
                    </div>
                    <!-- Progress Bar -->
                    <div class="d-flex align-items-center gap-2">
                        <div class="flex-grow-1"
                            style="height: 6px; background: var(--secondary-dark); border-radius: 3px; overflow: hidden;">
                            <div style="width: 65%; height: 100%; background: var(--gold-color);"></div>
                        </div>
                        <small class="text-muted" style="font-size: 11px;">65%</small>
                    </div>
                    <small class="text-muted d-block mt-1" style="font-size: 11px;">
                        <i class="bi bi-clock"></i> 10 hari lagi
                    </small>
                </div>

                <!-- Investment Item 2 -->
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">Ethereum Package</div>
                            <small class="text-muted">$ 2,500 • ROI 12% / bulan</small>
                        </div>
                        <span class="text-gold fw-bold" style="font-size: 14px;">$ 300</span>
                    </div>
                    <!-- Progress Bar -->
                    <div class="d-flex align-items-center gap-2">
                        <div class="flex-grow-1"
                            style="height: 6px; background: var(--secondary-dark); border-radius: 3px; overflow: hidden;">
                            <div style="width: 40%; height: 100%; background: var(--gold-color);"></div>
                        </div>
                        <small class="text-muted" style="font-size: 11px;">40%</small>
                    </div>
                    <small class="text-muted d-block mt-1" style="font-size: 11px;">
                        <i class="bi bi-clock"></i> 18 hari lagi
                    </small>
                </div>

                <!-- Investment Item 3 -->
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">USDT Package</div>
                            <small class="text-muted">$ 1,630 • ROI 10% / bulan</small>
                        </div>
                        <span class="text-gold fw-bold" style="font-size: 14px;">$ 163</span>
                    </div>
                    <!-- Progress Bar -->
                    <div class="d-flex align-items-center gap-2">
                        <div class="flex-grow-1"
                            style="height: 6px; background: var(--secondary-dark); border-radius: 3px; overflow: hidden;">
                            <div style="width: 85%; height: 100%; background: var(--gold-color);"></div>
                        </div>
                        <small class="text-muted" style="font-size: 11px;">85%</small>
                    </div>
                    <small class="text-muted d-block mt-1" style="font-size: 11px;">
                        <i class="bi bi-clock"></i> 5 hari lagi
                    </small>
                </div>

                <div class="p-3">
                    <a href="#" class="text-gold text-decoration-none small fw-bold">
                        Lihat Semua Investment <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Card 4: Referral Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-start gap-3">
                    <div
                        style="width: 50px; height: 50px; background: linear-gradient(135deg, rgba(245, 166, 35, 0.2) 0%, rgba(245, 166, 35, 0.1) 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; border: 1px solid rgba(245, 166, 35, 0.3); flex-shrink: 0;">
                        <i class="bi bi-share text-gold" style="font-size: 24px;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="text-white mb-1">Referral Code</h6>
                        <p class="text-muted small mb-2">Ajak teman dan dapatkan komisi!</p>
                        <div class="d-flex gap-2">
                            <div class="flex-grow-1"
                                style="background: var(--secondary-dark); border: 1px solid var(--border-color); border-radius: 6px; padding: 8px 12px;">
                                <code class="text-gold" style="font-size: 13px; letter-spacing: 1px;">JOHN2024XYZ</code>
                            </div>
                            <button class="btn btn-gold btn-sm" style="padding: 8px 16px;">
                                <i class="bi bi-clipboard"></i>
                            </button>
                        </div>
                        <small class="text-muted d-block mt-2" style="font-size: 11px;">
                            <i class="bi bi-person-check"></i> 24 referral aktif
                        </small>
                    </div>
                </div>
            </div>

            <!-- Card 5: Recent Activities -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <h6 class="text-white mb-0">Recent Activities</h6>
                </div>

                <!-- Activity Item 1 -->
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center gap-3">
                        <div
                            style="width: 36px; height: 36px; background: rgba(40, 167, 69, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="bi bi-arrow-down-circle" style="color: #28a745; font-size: 18px;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-white fw-bold mb-1" style="font-size: 13px;">Deposit</div>
                            <small class="text-muted" style="font-size: 11px;">2 jam yang lalu</small>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold" style="font-size: 14px;">+ $ 500</div>
                            <small class="text-muted" style="font-size: 11px;">Success</small>
                        </div>
                    </div>
                </div>

                <!-- Activity Item 2 -->
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center gap-3">
                        <div
                            style="width: 36px; height: 36px; background: rgba(245, 166, 35, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="bi bi-trophy" style="color: var(--gold-color); font-size: 18px;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-white fw-bold mb-1" style="font-size: 13px;">Profit Diterima</div>
                            <small class="text-muted" style="font-size: 11px;">5 jam yang lalu</small>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold" style="font-size: 14px;">+ $ 120</div>
                            <small class="text-muted" style="font-size: 11px;">BTC Package</small>
                        </div>
                    </div>
                </div>

                <!-- Activity Item 3 -->
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center gap-3">
                        <div
                            style="width: 36px; height: 36px; background: rgba(59, 181, 232, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="bi bi-people" style="color: var(--blue-color); font-size: 18px;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-white fw-bold mb-1" style="font-size: 13px;">Komisi Referral</div>
                            <small class="text-muted" style="font-size: 11px;">1 hari yang lalu</small>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold" style="font-size: 14px;">+ $ 50</div>
                            <small class="text-muted" style="font-size: 11px;">From JaneDoe</small>
                        </div>
                    </div>
                </div>

                <!-- Activity Item 4 -->
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center gap-3">
                        <div
                            style="width: 36px; height: 36px; background: rgba(220, 53, 69, 0.15); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="bi bi-arrow-up-circle" style="color: #dc3545; font-size: 18px;"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-white fw-bold mb-1" style="font-size: 13px;">Withdraw</div>
                            <small class="text-muted" style="font-size: 11px;">2 hari yang lalu</small>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold" style="font-size: 14px;">- $ 200</div>
                            <small class="text-muted" style="font-size: 11px;">Pending</small>
                        </div>
                    </div>
                </div>

                <div class="p-3">
                    <a href="#" class="text-gold text-decoration-none small fw-bold">
                        Lihat Semua Aktivitas <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <!-- Card 6: Market Overview (Mini Crypto Ticker) -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <h6 class="text-white mb-0">Market Overview</h6>
                </div>

                <!-- Crypto Item 1 - Bitcoin -->
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                style="width: 36px; height: 36px; background: rgba(247, 147, 26, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-currency-bitcoin" style="color: #f7931a; font-size: 20px;"></i>
                            </div>
                            <div>
                                <div class="text-white fw-bold" style="font-size: 14px;">Bitcoin</div>
                                <small class="text-muted">BTC</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold" style="font-size: 14px;">$ 43,250</div>
                            <small style="color: #28a745; font-size: 11px;">
                                <i class="bi bi-arrow-up"></i> +2.5%
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Crypto Item 2 - Ethereum -->
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                style="width: 36px; height: 36px; background: rgba(98, 126, 234, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-currency-exchange" style="color: #627eea; font-size: 20px;"></i>
                            </div>
                            <div>
                                <div class="text-white fw-bold" style="font-size: 14px;">Ethereum</div>
                                <small class="text-muted">ETH</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold" style="font-size: 14px;">$ 2,280</div>
                            <small style="color: #dc3545; font-size: 11px;">
                                <i class="bi bi-arrow-down"></i> -1.2%
                            </small>
                        </div>
                    </div>
                </div>

                <!-- Crypto Item 3 - USDT -->
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div
                                style="width: 36px; height: 36px; background: rgba(38, 161, 123, 0.15); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-currency-dollar" style="color: #26a17b; font-size: 20px;"></i>
                            </div>
                            <div>
                                <div class="text-white fw-bold" style="font-size: 14px;">Tether</div>
                                <small class="text-muted">USDT</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold" style="font-size: 14px;">$ 1.00</div>
                            <small style="color: #6c757d; font-size: 11px;">
                                <i class="bi bi-dash"></i> 0.0%
                            </small>
                        </div>
                    </div>
                </div>

                <div class="p-3">
                    <a href="#" class="text-gold text-decoration-none small fw-bold">
                        Lihat Semua Market <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection
