@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            {{-- <h5 class="text-white mb-3">Investasi</h5> --}}

            <!-- Portfolio Summary Card -->
            {{-- <div class="card-dark shadow-sm p-3 mb-3">
                <div class="row g-3">
                    <div class="col-6">
                        <p class="text-muted mb-1 small">Total Invested</p>
                        <h6 class="text-white mb-0 fw-bold">$ 5,000.00</h6>
                    </div>
                    <div class="col-6">
                        <p class="text-muted mb-1 small">Total Profit</p>
                        <h6 class="text-success mb-0 fw-bold">+ $ 850.00</h6>
                    </div>
                </div>
            </div> --}}

            <!-- Coins List Card -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <h6 class="text-white mb-0">Available Coins</h6>
                </div>

                <!-- Coin Item 1: BTC/USDT -->
                <a href="{{ route('member.invest.detail', ['coin' => 'btc']) }}" class="coin-list-item">
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
                </a>

                <!-- Coin Item 2: ETH/USDT -->
                <a href="{{ route('member.invest.detail', ['coin' => 'eth']) }}" class="coin-list-item">
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
                </a>

                <!-- Coin Item 3: DOGE/USDT -->
                <a href="{{ route('member.invest.detail', ['coin' => 'doge']) }}" class="coin-list-item">
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
                </a>

                <!-- Coin Item 4: BNB/USDT -->
                <a href="{{ route('member.invest.detail', ['coin' => 'bnb']) }}" class="coin-list-item">
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
                </a>

                <!-- Coin Item 5: SOL/USDT -->
                <a href="{{ route('member.invest.detail', ['coin' => 'sol']) }}" class="coin-list-item">
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
                </a>

                <!-- Coin Item 6: XRP/USDT -->
                <a href="{{ route('member.invest.detail', ['coin' => 'xrp']) }}" class="coin-list-item"
                    style="border-bottom: none;">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="coin-icon xrp">
                                <i class="bi bi-water"></i>
                            </div>
                            <div>
                                <div class="text-white fw-bold mb-1" style="font-size: 14px;">XRP/USDT</div>
                                <small class="text-muted">Ripple</small>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="text-white fw-bold mb-1" style="font-size: 14px;">$0.5432</div>
                            <small class="price-change negative">-1.24%</small>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Info Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-info-circle-fill text-gold" style="font-size: 18px; margin-top: 2px;"></i>
                    <div>
                        <h6 class="text-white mb-1" style="font-size: 13px;">Informasi</h6>
                        <p class="small text-muted mb-0" style="font-size: 12px;">
                            Klik pada coin untuk melihat detail dan melakukan trading. Pastikan Anda memahami risiko sebelum
                            berinvestasi.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
