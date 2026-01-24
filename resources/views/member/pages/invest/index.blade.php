@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Balance Summary Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="row g-3">
                    <div class="col-4">
                        <p class="text-muted mb-1 small">Trade Balance</p>
                        <h6 class="text-white mb-0 fw-bold">$ {{ number_format(auth()->user()->trade_balance, 2) }}</h6>
                    </div>
                    <div class="col-4">
                        <p class="text-muted mb-1 small">Available</p>
                        <h6 class="text-success mb-0 fw-bold">$
                            {{ number_format(auth()->user()->getAvailableTradeBalance(), 2) }}</h6>
                    </div>
                    <div class="col-4">
                        <p class="text-muted mb-1 small">Locked</p>
                        <h6 class="text-warning mb-0 fw-bold">$ {{ number_format(auth()->user()->locked_balance, 2) }}</h6>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            {{-- <div class="row g-2 mb-3">
                <div class="col-6">
                    <a href="{{ route('member.invest.history') }}" class="btn btn-outline-light w-100 btn-sm">
                        <i class="bi bi-clock-history me-1"></i>Historical Orders
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('member.balance.transfer') }}" class="btn btn-outline-light w-100 btn-sm">
                        <i class="bi bi-arrow-left-right me-1"></i>Transfer Balance
                    </a>
                </div>
            </div> --}}

            <!-- Coins List Card -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <h6 class="text-white mb-0">Select Coin for Trading Signals</h6>
                </div>

                @foreach ($coins as $symbol => $info)
                    <!-- Coin Item -->
                    <a href="{{ route('member.invest.detail', ['coin' => strtolower($symbol)]) }}" class="coin-list-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3 flex-grow-1">
                                <div class="coin-icon"
                                    style="background: linear-gradient(135deg, {{ $info['color'] }} 0%, {{ $info['color'] }}dd 100%);">
                                    <i class="{{ $info['icon'] }}"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-white fw-bold mb-1" style="font-size: 14px;">{{ $info['symbol'] }}
                                    </div>
                                    <small class="text-muted">{{ $info['name'] }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                @if ($signalCounts[$symbol] > 0)
                                    <div class="mb-1">
                                        <span class="badge badge-success" style="font-size: 11px;">
                                            <i class="bi bi-broadcast me-1"></i>{{ $signalCounts[$symbol] }}
                                            Signal{{ $signalCounts[$symbol] > 1 ? 's' : '' }}
                                        </span>
                                    </div>
                                @else
                                    <small class="text-muted">No signals</small>
                                @endif
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Info Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-info-circle-fill text-gold" style="font-size: 18px; margin-top: 2px;"></i>
                    <div>
                        <h6 class="text-white mb-1" style="font-size: 13px;">How to Trade</h6>
                        <p class="small text-muted mb-0" style="font-size: 12px;">
                            Select a coin to view available trading signals. Minimum $100.00 available Trade Balance
                            required to join signals.
                            Your bet is calculated as 1% of your Trade Balance.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        </script>
    @endpush
@endsection
