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

            <!-- Trading Signals List Card -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <h6 class="text-white mb-0">Available Trading Signals</h6>
                </div>

                @forelse($openSignals as $signal)
                    <a href="{{ route('member.invest.detail', ['signal_id' => $signal->id]) }}" class="coin-list-item">
                        <div class="d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-3 flex-grow-1">
                                <div class="coin-icon"
                                    style="background: linear-gradient(135deg, #f5a623 0%, #f7b733 100%);">
                                    <i class="bi bi-broadcast"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-white fw-bold mb-1" style="font-size: 14px;">{{ $signal->title }}</div>
                                    <small class="text-muted">
                                        <i class="bi bi-people me-1"></i>{{ $signal->participants_count }} Participants
                                        @if (in_array($signal->id, $joinedSignalIds))
                                            <span class="badge badge-primary ms-2" style="font-size: 9px;">JOINED</span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                            <div class="text-end">
                                @if ($signal->entry_price)
                                    <div class="text-white fw-bold mb-1" style="font-size: 14px;">$
                                        {{ number_format($signal->entry_price, 2) }}</div>
                                @endif
                                <span class="badge badge-success" style="font-size: 10px;">
                                    <i class="bi bi-circle-fill" style="font-size: 6px;"></i> OPEN
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="p-5 text-center">
                        <i class="bi bi-broadcast-pin text-muted" style="font-size: 48px;"></i>
                        <p class="text-muted mt-3 mb-0">No signals available</p>
                        <small class="text-muted">Check back later for new trading signals</small>
                    </div>
                @endforelse
            </div>

            <!-- Info Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-info-circle-fill text-gold" style="font-size: 18px; margin-top: 2px;"></i>
                    <div>
                        <h6 class="text-white mb-1" style="font-size: 13px;">How to Trade</h6>
                        <p class="small text-muted mb-0" style="font-size: 12px;">
                            Click on any signal to view details and join. Minimum $100.00 available Trade Balance required.
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
