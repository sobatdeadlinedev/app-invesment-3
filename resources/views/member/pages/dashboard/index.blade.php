@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <!-- Tab Navigation -->
            <div class="tab-navigation">
                <button class="tab-btn active" data-tab="digital">Digital Currency</button>
                <button class="tab-btn" data-tab="forex">Forex</button>
                <button class="tab-btn" data-tab="precious">Precious Metals</button>
            </div>

            @if ($announcement && !empty($announcement))
                <!-- Announcement Card -->
                <div class="card-dark shadow-sm p-3 mb-3 mt-3">
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

            <!-- Hot Section Card -->
            <div class="card-dark shadow-sm p-3 mb-3 mt-3"
                style="background: linear-gradient(135deg, rgba(169, 126, 0, 0.15) 0%, rgba(169, 126, 0, 0.05) 100%); border: 2px solid rgba(169, 126, 0, 0.3);">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="text-gold mb-0 fw-bold" style="font-size: 18px;">
                        <i class="bi bi-fire me-2"></i>Hot
                    </h5>
                </div>

                <!-- Hot Coins Grid -->
                <div class="row g-2">
                    <!-- BTC Card -->
                    <div class="col-6">
                        <div class="card-dark p-3" style="background: #FFFFFF; border: 1px solid var(--border-color);">
                            <div class="mb-2">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold"
                                        style="font-size: 13px; color: var(--text-primary);">BTCUSDT</span>
                                    <div class="coin-icon btc" style="width: 24px; height: 24px;">
                                        <i class="bi bi-currency-bitcoin" style="font-size: 14px;"></i>
                                    </div>
                                </div>
                                <div class="fw-bold mb-1" style="font-size: 16px; color: var(--text-primary);">
                                    ${{ $cryptoPrices['BTCUSDT']['price'] ?? '0.00' }}
                                </div>
                                <small
                                    class="price-change {{ $cryptoPrices['BTCUSDT']['isPositive'] ? 'positive' : 'negative' }}"
                                    style="font-size: 11px;">
                                    @if ($cryptoPrices['BTCUSDT']['isPositive'])
                                        <i class="bi bi-arrow-up"></i>
                                    @else
                                        <i class="bi bi-arrow-down"></i>
                                    @endif
                                    {{ $cryptoPrices['BTCUSDT']['change'] }}%
                                </small>
                            </div>
                            <!-- Mini Chart Placeholder -->
                            <div class="mini-chart {{ $cryptoPrices['BTCUSDT']['isPositive'] ? 'positive' : 'negative' }}">
                                <svg width="100%" height="60" viewBox="0 0 100 60" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="gradient-btc" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%"
                                                style="stop-color:{{ $cryptoPrices['BTCUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }};stop-opacity:0.3" />
                                            <stop offset="100%"
                                                style="stop-color:{{ $cryptoPrices['BTCUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }};stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path
                                        d="M0,45 L20,40 L40,30 L60,35 L80,25 L100,{{ $cryptoPrices['BTCUSDT']['isPositive'] ? '20' : '40' }}"
                                        fill="none"
                                        stroke="{{ $cryptoPrices['BTCUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }}"
                                        stroke-width="2" />
                                    <path
                                        d="M0,45 L20,40 L40,30 L60,35 L80,25 L100,{{ $cryptoPrices['BTCUSDT']['isPositive'] ? '20' : '40' }} L100,60 L0,60 Z"
                                        fill="url(#gradient-btc)" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- ETH Card -->
                    <div class="col-6">
                        <div class="card-dark p-3" style="background: #FFFFFF; border: 1px solid var(--border-color);">
                            <div class="mb-2">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold"
                                        style="font-size: 13px; color: var(--text-primary);">ETHUSDT</span>
                                    <div class="coin-icon eth" style="width: 24px; height: 24px;">
                                        <i class="bi bi-currency-exchange" style="font-size: 14px;"></i>
                                    </div>
                                </div>
                                <div class="fw-bold mb-1" style="font-size: 16px; color: var(--text-primary);">
                                    ${{ $cryptoPrices['ETHUSDT']['price'] ?? '0.00' }}
                                </div>
                                <small
                                    class="price-change {{ $cryptoPrices['ETHUSDT']['isPositive'] ? 'positive' : 'negative' }}"
                                    style="font-size: 11px;">
                                    @if ($cryptoPrices['ETHUSDT']['isPositive'])
                                        <i class="bi bi-arrow-up"></i>
                                    @else
                                        <i class="bi bi-arrow-down"></i>
                                    @endif
                                    {{ $cryptoPrices['ETHUSDT']['change'] }}%
                                </small>
                            </div>
                            <!-- Mini Chart Placeholder -->
                            <div class="mini-chart {{ $cryptoPrices['ETHUSDT']['isPositive'] ? 'positive' : 'negative' }}">
                                <svg width="100%" height="60" viewBox="0 0 100 60" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="gradient-eth" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%"
                                                style="stop-color:{{ $cryptoPrices['ETHUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }};stop-opacity:0.3" />
                                            <stop offset="100%"
                                                style="stop-color:{{ $cryptoPrices['ETHUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }};stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path
                                        d="M0,50 L20,45 L40,35 L60,40 L80,30 L100,{{ $cryptoPrices['ETHUSDT']['isPositive'] ? '25' : '45' }}"
                                        fill="none"
                                        stroke="{{ $cryptoPrices['ETHUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }}"
                                        stroke-width="2" />
                                    <path
                                        d="M0,50 L20,45 L40,35 L60,40 L80,30 L100,{{ $cryptoPrices['ETHUSDT']['isPositive'] ? '25' : '45' }} L100,60 L0,60 Z"
                                        fill="url(#gradient-eth)" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- DOGE Card -->
                    <div class="col-6">
                        <div class="card-dark p-3" style="background: #FFFFFF; border: 1px solid var(--border-color);">
                            <div class="mb-2">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold"
                                        style="font-size: 13px; color: var(--text-primary);">DOGEUSDT</span>
                                    <div class="coin-icon doge" style="width: 24px; height: 24px;">
                                        <i class="bi bi-coin" style="font-size: 14px;"></i>
                                    </div>
                                </div>
                                <div class="fw-bold mb-1" style="font-size: 16px; color: var(--text-primary);">
                                    ${{ $cryptoPrices['DOGEUSDT']['price'] ?? '0.00' }}
                                </div>
                                <small
                                    class="price-change {{ $cryptoPrices['DOGEUSDT']['isPositive'] ? 'positive' : 'negative' }}"
                                    style="font-size: 11px;">
                                    @if ($cryptoPrices['DOGEUSDT']['isPositive'])
                                        <i class="bi bi-arrow-up"></i>
                                    @else
                                        <i class="bi bi-arrow-down"></i>
                                    @endif
                                    {{ $cryptoPrices['DOGEUSDT']['change'] }}%
                                </small>
                            </div>
                            <!-- Mini Chart Placeholder -->
                            <div
                                class="mini-chart {{ $cryptoPrices['DOGEUSDT']['isPositive'] ? 'positive' : 'negative' }}">
                                <svg width="100%" height="60" viewBox="0 0 100 60" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="gradient-doge" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%"
                                                style="stop-color:{{ $cryptoPrices['DOGEUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }};stop-opacity:0.3" />
                                            <stop offset="100%"
                                                style="stop-color:{{ $cryptoPrices['DOGEUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }};stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path
                                        d="M0,40 L20,38 L40,42 L60,35 L80,37 L100,{{ $cryptoPrices['DOGEUSDT']['isPositive'] ? '30' : '45' }}"
                                        fill="none"
                                        stroke="{{ $cryptoPrices['DOGEUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }}"
                                        stroke-width="2" />
                                    <path
                                        d="M0,40 L20,38 L40,42 L60,35 L80,37 L100,{{ $cryptoPrices['DOGEUSDT']['isPositive'] ? '30' : '45' }} L100,60 L0,60 Z"
                                        fill="url(#gradient-doge)" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- BNB Card -->
                    <div class="col-6">
                        <div class="card-dark p-3" style="background: #FFFFFF; border: 1px solid var(--border-color);">
                            <div class="mb-2">
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold"
                                        style="font-size: 13px; color: var(--text-primary);">BNBUSDT</span>
                                    <div class="coin-icon bnb" style="width: 24px; height: 24px;">
                                        <i class="bi bi-triangle-fill" style="font-size: 14px;"></i>
                                    </div>
                                </div>
                                <div class="fw-bold mb-1" style="font-size: 16px; color: var(--text-primary);">
                                    ${{ $cryptoPrices['BNBUSDT']['price'] ?? '0.00' }}
                                </div>
                                <small
                                    class="price-change {{ $cryptoPrices['BNBUSDT']['isPositive'] ? 'positive' : 'negative' }}"
                                    style="font-size: 11px;">
                                    @if ($cryptoPrices['BNBUSDT']['isPositive'])
                                        <i class="bi bi-arrow-up"></i>
                                    @else
                                        <i class="bi bi-arrow-down"></i>
                                    @endif
                                    {{ $cryptoPrices['BNBUSDT']['change'] }}%
                                </small>
                            </div>
                            <!-- Mini Chart Placeholder -->
                            <div
                                class="mini-chart {{ $cryptoPrices['BNBUSDT']['isPositive'] ? 'positive' : 'negative' }}">
                                <svg width="100%" height="60" viewBox="0 0 100 60" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="gradient-bnb" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%"
                                                style="stop-color:{{ $cryptoPrices['BNBUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }};stop-opacity:0.3" />
                                            <stop offset="100%"
                                                style="stop-color:{{ $cryptoPrices['BNBUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }};stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path
                                        d="M0,42 L20,39 L40,33 L60,38 L80,28 L100,{{ $cryptoPrices['BNBUSDT']['isPositive'] ? '22' : '43' }}"
                                        fill="none"
                                        stroke="{{ $cryptoPrices['BNBUSDT']['isPositive'] ? '#22c55e' : '#ef4444' }}"
                                        stroke-width="2" />
                                    <path
                                        d="M0,42 L20,39 L40,33 L60,38 L80,28 L100,{{ $cryptoPrices['BNBUSDT']['isPositive'] ? '22' : '43' }} L100,60 L0,60 Z"
                                        fill="url(#gradient-bnb)" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- All Markets Section -->
            <div class="mb-4 mt-3">
                <!-- Digital Currency Section -->
                <div class="market-section" id="section-digital" data-category="digital">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-3">
                        <h6 class="mb-0 fw-bold" style="color: var(--text-primary); font-size: 15px;">
                            Cryptocurrency
                        </h6>
                    </div>

                    <!-- Crypto Cards Grid (3 columns) -->
                    <div class="coin-cards-grid crypto-grid">
                        <!-- BTCUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">BTCUSDT</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $43,250.50
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +2.45%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-btc" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,50 L10,48 L20,45 L30,42 L40,38 L50,35 L60,32 L70,28 L80,25 L90,22 L100,20"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,50 L10,48 L20,45 L30,42 L40,38 L50,35 L60,32 L70,28 L80,25 L90,22 L100,20 L100,70 L0,70 Z"
                                        fill="url(#grad-btc)" />
                                </svg>
                            </div>
                        </div>

                        <!-- ETHUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">ETHUSDT</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $2,914.66
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +1.87%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-eth" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,55 L10,52 L20,48 L30,45 L40,40 L50,38 L60,35 L70,30 L80,28 L90,24 L100,22"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,55 L10,52 L20,48 L30,45 L40,40 L50,38 L60,35 L70,30 L80,28 L90,24 L100,22 L100,70 L0,70 Z"
                                        fill="url(#grad-eth)" />
                                </svg>
                            </div>
                        </div>

                        <!-- XRPUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">XRPUSDT</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $0.5234
                                </div>
                                <small class="price-change-mini negative" style="font-size: 11px;">
                                    <i class="bi bi-arrow-down"></i> -0.92%
                                </small>
                            </div>
                            <div class="coin-mini-chart negative">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-xrp" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#ef4444;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#ef4444;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,20 L10,22 L20,25 L30,28 L40,32 L50,35 L60,38 L70,42 L80,45 L90,48 L100,50"
                                        fill="none" stroke="#ef4444" stroke-width="2" />
                                    <path
                                        d="M0,20 L10,22 L20,25 L30,28 L40,32 L50,35 L60,38 L70,42 L80,45 L90,48 L100,50 L100,70 L0,70 Z"
                                        fill="url(#grad-xrp)" />
                                </svg>
                            </div>
                        </div>

                        <!-- LINKUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">LINKUSDT</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $14.23
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +3.12%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-link" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,52 L10,49 L20,46 L30,43 L40,39 L50,36 L60,33 L70,29 L80,26 L90,23 L100,21"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,52 L10,49 L20,46 L30,43 L40,39 L50,36 L60,33 L70,29 L80,26 L90,23 L100,21 L100,70 L0,70 Z"
                                        fill="url(#grad-link)" />
                                </svg>
                            </div>
                        </div>

                        <!-- DOTUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">DOTUSDT</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $7.89
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +1.23%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-dot" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,48 L10,46 L20,44 L30,41 L40,38 L50,36 L60,33 L70,30 L80,28 L90,25 L100,23"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,48 L10,46 L20,44 L30,41 L40,38 L50,36 L60,33 L70,30 L80,28 L90,25 L100,23 L100,70 L0,70 Z"
                                        fill="url(#grad-dot)" />
                                </svg>
                            </div>
                        </div>

                        <!-- DOGEUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">DOGEUSDT</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $0.0812
                                </div>
                                <small class="price-change-mini negative" style="font-size: 11px;">
                                    <i class="bi bi-arrow-down"></i> -1.45%
                                </small>
                            </div>
                            <div class="coin-mini-chart negative">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-doge2" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#ef4444;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#ef4444;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,22 L10,24 L20,27 L30,30 L40,33 L50,36 L60,39 L70,41 L80,43 L90,46 L100,48"
                                        fill="none" stroke="#ef4444" stroke-width="2" />
                                    <path
                                        d="M0,22 L10,24 L20,27 L30,30 L40,33 L50,36 L60,39 L70,41 L80,43 L90,46 L100,48 L100,70 L0,70 Z"
                                        fill="url(#grad-doge2)" />
                                </svg>
                            </div>
                        </div>

                        <!-- BCHUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">BCHUSDT</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $245.67
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +2.15%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-bch" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,46 L10,44 L20,42 L30,39 L40,36 L50,34 L60,31 L70,28 L80,26 L90,23 L100,21"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,46 L10,44 L20,42 L30,39 L40,36 L50,34 L60,31 L70,28 L80,26 L90,23 L100,21 L100,70 L0,70 Z"
                                        fill="url(#grad-bch)" />
                                </svg>
                            </div>
                        </div>

                        <!-- FILUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">FILUSDT</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $5.42
                                </div>
                                <small class="price-change-mini negative" style="font-size: 11px;">
                                    <i class="bi bi-arrow-down"></i> -0.78%
                                </small>
                            </div>
                            <div class="coin-mini-chart negative">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-fil" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#ef4444;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#ef4444;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,24 L10,26 L20,28 L30,31 L40,34 L50,36 L60,38 L70,40 L80,42 L90,44 L100,46"
                                        fill="none" stroke="#ef4444" stroke-width="2" />
                                    <path
                                        d="M0,24 L10,26 L20,28 L30,31 L40,34 L50,36 L60,38 L70,40 L80,42 L90,44 L100,46 L100,70 L0,70 Z"
                                        fill="url(#grad-fil)" />
                                </svg>
                            </div>
                        </div>

                        <!-- LTCUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">LTCUSDT</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $73.21
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +1.56%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-ltc" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,49 L10,47 L20,44 L30,41 L40,38 L50,35 L60,32 L70,29 L80,27 L90,24 L100,22"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,49 L10,47 L20,44 L30,41 L40,38 L50,35 L60,32 L70,29 L80,27 L90,24 L100,22 L100,70 L0,70 Z"
                                        fill="url(#grad-ltc)" />
                                </svg>
                            </div>
                        </div>

                        <!-- ZECUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">ZECUSDT</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $42.89
                                </div>
                                <small class="price-change-mini negative" style="font-size: 11px;">
                                    <i class="bi bi-arrow-down"></i> -2.34%
                                </small>
                            </div>
                            <div class="coin-mini-chart negative">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-zec" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#ef4444;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#ef4444;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,21 L10,23 L20,26 L30,29 L40,32 L50,35 L60,38 L70,41 L80,44 L90,47 L100,49"
                                        fill="none" stroke="#ef4444" stroke-width="2" />
                                    <path
                                        d="M0,21 L10,23 L20,26 L30,29 L40,32 L50,35 L60,38 L70,41 L80,44 L90,47 L100,49 L100,70 L0,70 Z"
                                        fill="url(#grad-zec)" />
                                </svg>
                            </div>
                        </div>

                        <!-- DASHUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">DASHUSDT</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $31.56
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +0.89%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-dash" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,51 L10,49 L20,46 L30,43 L40,40 L50,37 L60,34 L70,31 L80,28 L90,25 L100,23"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,51 L10,49 L20,46 L30,43 L40,40 L50,37 L60,34 L70,31 L80,28 L90,25 L100,23 L100,70 L0,70 Z"
                                        fill="url(#grad-dash)" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Forex Section -->
                <div class="market-section" id="section-forex" data-category="forex">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-3">
                        <h6 class="mb-0 fw-bold" style="color: var(--text-primary); font-size: 15px;">
                            Forex
                        </h6>
                    </div>

                    <!-- Forex Cards Grid (2 columns) -->
                    <div class="coin-cards-grid forex-grid">
                        <!-- HKDUSD -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">HKDUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $0.1283
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +0.12%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-hkd" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,50 L10,48 L20,46 L30,43 L40,40 L50,38 L60,35 L70,32 L80,30 L90,27 L100,25"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,50 L10,48 L20,46 L30,43 L40,40 L50,38 L60,35 L70,32 L80,30 L90,27 L100,25 L100,70 L0,70 Z"
                                        fill="url(#grad-hkd)" />
                                </svg>
                            </div>
                        </div>

                        <!-- INRUSD -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">INRUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $0.0120
                                </div>
                                <small class="price-change-mini negative" style="font-size: 11px;">
                                    <i class="bi bi-arrow-down"></i> -0.08%
                                </small>
                            </div>
                            <div class="coin-mini-chart negative">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-inr" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#ef4444;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#ef4444;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,25 L10,27 L20,29 L30,32 L40,35 L50,37 L60,40 L70,42 L80,44 L90,46 L100,48"
                                        fill="none" stroke="#ef4444" stroke-width="2" />
                                    <path
                                        d="M0,25 L10,27 L20,29 L30,32 L40,35 L50,37 L60,40 L70,42 L80,44 L90,46 L100,48 L100,70 L0,70 Z"
                                        fill="url(#grad-inr)" />
                                </svg>
                            </div>
                        </div>

                        <!-- KRWUSD -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">KRWUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $0.0007
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +0.15%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-krw" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,52 L10,50 L20,47 L30,44 L40,41 L50,38 L60,35 L70,32 L80,29 L90,26 L100,24"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,52 L10,50 L20,47 L30,44 L40,41 L50,38 L60,35 L70,32 L80,29 L90,26 L100,24 L100,70 L0,70 Z"
                                        fill="url(#grad-krw)" />
                                </svg>
                            </div>
                        </div>

                        <!-- SGDUSD -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">SGDUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $0.7456
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +0.21%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-sgd" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,48 L10,46 L20,44 L30,41 L40,38 L50,36 L60,33 L70,30 L80,28 L90,25 L100,23"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,48 L10,46 L20,44 L30,41 L40,38 L50,36 L60,33 L70,30 L80,28 L90,25 L100,23 L100,70 L0,70 Z"
                                        fill="url(#grad-sgd)" />
                                </svg>
                            </div>
                        </div>

                        <!-- BRLUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">BRLUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $0.1987
                                </div>
                                <small class="price-change-mini negative" style="font-size: 11px;">
                                    <i class="bi bi-arrow-down"></i> -0.34%
                                </small>
                            </div>
                            <div class="coin-mini-chart negative">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-brl" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#ef4444;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#ef4444;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,23 L10,25 L20,28 L30,31 L40,34 L50,36 L60,39 L70,41 L80,43 L90,45 L100,47"
                                        fill="none" stroke="#ef4444" stroke-width="2" />
                                    <path
                                        d="M0,23 L10,25 L20,28 L30,31 L40,34 L50,36 L60,39 L70,41 L80,43 L90,45 L100,47 L100,70 L0,70 Z"
                                        fill="url(#grad-brl)" />
                                </svg>
                            </div>
                        </div>

                        <!-- TRYUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">TRYUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $0.0312
                                </div>
                                <small class="price-change-mini negative" style="font-size: 11px;">
                                    <i class="bi bi-arrow-down"></i> -0.56%
                                </small>
                            </div>
                            <div class="coin-mini-chart negative">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-try" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#ef4444;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#ef4444;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,26 L10,28 L20,30 L30,33 L40,36 L50,38 L60,40 L70,42 L80,44 L90,46 L100,48"
                                        fill="none" stroke="#ef4444" stroke-width="2" />
                                    <path
                                        d="M0,26 L10,28 L20,30 L30,33 L40,36 L50,38 L60,40 L70,42 L80,44 L90,46 L100,48 L100,70 L0,70 Z"
                                        fill="url(#grad-try)" />
                                </svg>
                            </div>
                        </div>

                        <!-- EURUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">EURUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $1.0856
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +0.18%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-eur" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,49 L10,47 L20,45 L30,42 L40,39 L50,36 L60,33 L70,30 L80,28 L90,25 L100,23"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,49 L10,47 L20,45 L30,42 L40,39 L50,36 L60,33 L70,30 L80,28 L90,25 L100,23 L100,70 L0,70 Z"
                                        fill="url(#grad-eur)" />
                                </svg>
                            </div>
                        </div>

                        <!-- GBPUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">GBPUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $1.2734
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +0.25%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-gbp" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,51 L10,49 L20,46 L30,43 L40,40 L50,37 L60,34 L70,31 L80,28 L90,25 L100,23"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,51 L10,49 L20,46 L30,43 L40,40 L50,37 L60,34 L70,31 L80,28 L90,25 L100,23 L100,70 L0,70 Z"
                                        fill="url(#grad-gbp)" />
                                </svg>
                            </div>
                        </div>

                        <!-- AUDUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">AUDUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $0.6734
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +0.32%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-aud" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,50 L10,48 L20,45 L30,42 L40,39 L50,36 L60,33 L70,30 L80,27 L90,24 L100,22"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,50 L10,48 L20,45 L30,42 L40,39 L50,36 L60,33 L70,30 L80,27 L90,24 L100,22 L100,70 L0,70 Z"
                                        fill="url(#grad-aud)" />
                                </svg>
                            </div>
                        </div>

                        <!-- NZDUSDT -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">NZDUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $0.6123
                                </div>
                                <small class="price-change-mini negative" style="font-size: 11px;">
                                    <i class="bi bi-arrow-down"></i> -0.19%
                                </small>
                            </div>
                            <div class="coin-mini-chart negative">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-nzd" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#ef4444;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#ef4444;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,24 L10,26 L20,29 L30,32 L40,35 L50,37 L60,40 L70,42 L80,44 L90,46 L100,48"
                                        fill="none" stroke="#ef4444" stroke-width="2" />
                                    <path
                                        d="M0,24 L10,26 L20,29 L30,32 L40,35 L50,37 L60,40 L70,42 L80,44 L90,46 L100,48 L100,70 L0,70 Z"
                                        fill="url(#grad-nzd)" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Precious Metals Section -->
                <div class="market-section" id="section-precious" data-category="precious">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-3">
                        <h6 class="mb-0 fw-bold" style="color: var(--text-primary); font-size: 15px;">
                            Precious Metals
                        </h6>
                    </div>

                    <!-- Precious Metals Cards Grid (2 columns) -->
                    <div class="coin-cards-grid forex-grid">
                        <!-- XAGUSD - Silver -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">XAGUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $24.56
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +1.23%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-xag" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,48 L10,46 L20,44 L30,41 L40,38 L50,35 L60,32 L70,29 L80,26 L90,24 L100,22"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,48 L10,46 L20,44 L30,41 L40,38 L50,35 L60,32 L70,29 L80,26 L90,24 L100,22 L100,70 L0,70 Z"
                                        fill="url(#grad-xag)" />
                                </svg>
                            </div>
                        </div>

                        <!-- XAUUSD - Gold -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">XAUUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $2,043.67
                                </div>
                                <small class="price-change-mini positive" style="font-size: 11px;">
                                    <i class="bi bi-arrow-up"></i> +0.87%
                                </small>
                            </div>
                            <div class="coin-mini-chart positive">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-xau" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#22c55e;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#22c55e;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,50 L10,48 L20,46 L30,43 L40,40 L50,37 L60,34 L70,31 L80,28 L90,25 L100,23"
                                        fill="none" stroke="#22c55e" stroke-width="2" />
                                    <path
                                        d="M0,50 L10,48 L20,46 L30,43 L40,40 L50,37 L60,34 L70,31 L80,28 L90,25 L100,23 L100,70 L0,70 Z"
                                        fill="url(#grad-xau)" />
                                </svg>
                            </div>
                        </div>

                        <!-- XPTUSD - Platinum -->
                        <div class="coin-card">
                            <div class="coin-card-header">
                                <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">XPTUSD</div>
                                <div class="fw-bold" style="font-size: 16px; color: var(--text-primary); margin: 4px 0;">
                                    $934.21
                                </div>
                                <small class="price-change-mini negative" style="font-size: 11px;">
                                    <i class="bi bi-arrow-down"></i> -0.45%
                                </small>
                            </div>
                            <div class="coin-mini-chart negative">
                                <svg width="100%" height="70" viewBox="0 0 100 70" preserveAspectRatio="none">
                                    <defs>
                                        <linearGradient id="grad-xpt" x1="0%" y1="0%" x2="0%"
                                            y2="100%">
                                            <stop offset="0%" style="stop-color:#ef4444;stop-opacity:0.4" />
                                            <stop offset="100%" style="stop-color:#ef4444;stop-opacity:0.05" />
                                        </linearGradient>
                                    </defs>
                                    <path d="M0,23 L10,25 L20,28 L30,31 L40,34 L50,36 L60,39 L70,41 L80,43 L90,45 L100,47"
                                        fill="none" stroke="#ef4444" stroke-width="2" />
                                    <path
                                        d="M0,23 L10,25 L20,28 L30,31 L40,34 L50,36 L60,39 L70,41 L80,43 L90,45 L100,47 L100,70 L0,70 Z"
                                        fill="url(#grad-xpt)" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .mini-chart {
                border-radius: 6px;
                overflow: hidden;
                background: rgba(0, 0, 0, 0.02);
            }

            .mini-chart svg {
                display: block;
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

            /* Coin Cards Grid - Default 3 columns for Crypto */
            .coin-cards-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
                padding: 0 16px;
            }

            /* Forex & Precious Metals - 2 columns */
            .coin-cards-grid.forex-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .coin-card {
                background: #FFFFFF;
                border: 1px solid var(--border-color);
                border-radius: 12px;
                padding: 12px;
                transition: all 0.2s ease;
            }

            .coin-card:hover {
                box-shadow: 0 4px 12px rgba(169, 126, 0, 0.1);
                border-color: rgba(169, 126, 0, 0.3);
                transform: translateY(-2px);
            }

            .coin-card-header {
                margin-bottom: 8px;
            }

            .coin-mini-chart {
                border-radius: 6px;
                overflow: hidden;
                background: rgba(0, 0, 0, 0.01);
                margin-top: 8px;
            }

            .coin-mini-chart svg {
                display: block;
            }

            .price-change-mini {
                display: inline-flex;
                align-items: center;
                gap: 3px;
                font-weight: 600;
            }

            .price-change-mini.positive {
                color: #22c55e;
            }

            .price-change-mini.negative {
                color: #ef4444;
            }

            /* Market Section */
            .market-section {
                margin-bottom: 20px;
            }

            /* Responsive - 2 columns for smaller screens */
            @media (max-width: 375px) {
                .coin-cards-grid {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 8px;
                    padding: 0 12px;
                }

                .coin-card {
                    padding: 10px;
                }
            }

            /* Responsive - 2 columns for medium screens */
            @media (min-width: 376px) and (max-width: 480px) {
                .coin-cards-grid.crypto-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Tab Navigation with Smooth Scroll
            document.addEventListener('DOMContentLoaded', function() {
                const tabButtons = document.querySelectorAll('.tab-btn');

                tabButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const targetTab = this.getAttribute('data-tab');

                        // Remove active class from all buttons
                        tabButtons.forEach(btn => btn.classList.remove('active'));

                        // Add active class to clicked button
                        this.classList.add('active');

                        // Scroll to target section
                        const targetSection = document.getElementById(`section-${targetTab}`);
                        if (targetSection) {
                            const yOffset = -80; // Offset untuk sticky header
                            const y = targetSection.getBoundingClientRect().top + window.pageYOffset +
                                yOffset;

                            // Smooth scroll
                            targetSection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });

                // Optional: Update active tab on scroll
                const observerOptions = {
                    root: null,
                    rootMargin: '-100px 0px -60% 0px',
                    threshold: 0
                };

                const observerCallback = (entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const category = entry.target.getAttribute('data-category');
                            tabButtons.forEach(btn => {
                                if (btn.getAttribute('data-tab') === category) {
                                    tabButtons.forEach(b => b.classList.remove('active'));
                                    btn.classList.add('active');
                                }
                            });
                        }
                    });
                };

                const observer = new IntersectionObserver(observerCallback, observerOptions);

                document.querySelectorAll('.market-section').forEach(section => {
                    observer.observe(section);
                });
            });

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
        </script>
    @endpush
@endsection
