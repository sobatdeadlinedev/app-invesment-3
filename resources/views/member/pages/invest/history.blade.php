@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">

            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('member.invest.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i>Back to Signals
                </a>
            </div>

            <!-- Statistics Cards -->
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <div class="card-dark shadow-sm p-3">
                        <p class="text-muted mb-1 small">Total Joined</p>
                        <h5 class="text-white mb-0 fw-bold">{{ $totalJoined }}</h5>
                        <small class="text-muted">Signals</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-dark shadow-sm p-3">
                        <p class="text-muted mb-1 small">Win Rate</p>
                        <h5 class="text-{{ $winRate >= 50 ? 'success' : 'danger' }} mb-0 fw-bold">
                            {{ number_format($winRate, 1) }}%</h5>
                        <small class="text-muted">{{ $totalWins }}/{{ $totalSettled }} Wins</small>
                    </div>
                </div>
            </div>

            <div class="row g-3 mb-3">
                <div class="col-6">
                    <div class="card-dark shadow-sm p-3">
                        <p class="text-muted mb-1 small">Total P/L</p>
                        <h6 class="text-{{ $totalProfitLoss >= 0 ? 'success' : 'danger' }} mb-0 fw-bold">
                            {{ $totalProfitLoss >= 0 ? '+' : '' }} $ {{ number_format($totalProfitLoss, 2) }}
                        </h6>
                        <small class="text-muted">Profit/Loss</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-dark shadow-sm p-3">
                        <p class="text-muted mb-1 small">Total Fees</p>
                        <h6 class="text-warning mb-0 fw-bold">$ {{ number_format($totalFees, 2) }}</h6>
                        <small class="text-muted">Trading Fees</small>
                    </div>
                </div>
            </div>

            <!-- History List -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <h6 class="text-white mb-0">Trading History</h6>
                </div>

                @forelse($participants as $participant)
                    <div class="coin-list-item">
                        <div class="d-flex flex-column gap-2">
                            <!-- Signal Header -->
                            <div class="d-flex align-items-start justify-content-between">
                                <div class="flex-grow-1">
                                    <div class="text-white fw-bold mb-1" style="font-size: 14px;">
                                        <i class="bi bi-broadcast text-gold me-2"></i>{{ $participant->signal->title }}
                                    </div>
                                    <small class="text-muted">{{ $participant->joined_at->format('d M Y, H:i') }}</small>
                                </div>
                                @if ($participant->status === 'joined')
                                    <span class="badge badge-warning" style="font-size: 10px;">
                                        <i class="bi bi-clock"></i> PENDING
                                    </span>
                                @else
                                    <span class="badge badge-success" style="font-size: 10px;">
                                        <i class="bi bi-check-circle"></i> SETTLED
                                    </span>
                                @endif
                            </div>

                            <!-- Bet Details -->
                            <div class="row g-2">
                                <div class="col-4">
                                    <small class="text-muted d-block" style="font-size: 10px;">Bet Amount</small>
                                    <small class="text-white fw-bold">$
                                        {{ number_format($participant->bet_amount, 2) }}</small>
                                </div>
                                @if ($participant->status === 'settled')
                                    <div class="col-4">
                                        <small class="text-muted d-block" style="font-size: 10px;">P/L</small>
                                        <small
                                            class="text-{{ $participant->profit_loss >= 0 ? 'success' : 'danger' }} fw-bold">
                                            {{ $participant->profit_loss >= 0 ? '+' : '' }} $
                                            {{ number_format($participant->profit_loss, 2) }}
                                        </small>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted d-block" style="font-size: 10px;">Fee</small>
                                        <small class="text-warning fw-bold">$
                                            {{ number_format($participant->fee_amount, 2) }}</small>
                                    </div>
                                @endif
                            </div>

                            <!-- Result (if settled) -->
                            @if ($participant->status === 'settled')
                                <div class="d-flex align-items-center justify-content-between pt-2"
                                    style="border-top: 1px solid var(--border-color);">
                                    <div>
                                        @if ($participant->signal->result === 'win')
                                            <span class="badge badge-success" style="font-size: 10px;">
                                                <i class="bi bi-trophy me-1"></i>WIN
                                            </span>
                                        @else
                                            <span class="badge badge-danger" style="font-size: 10px;">
                                                <i class="bi bi-x-circle me-1"></i>LOSS
                                            </span>
                                        @endif
                                        <small
                                            class="text-muted ms-2">{{ number_format($participant->signal->rate_of_return, 2) }}%
                                            RoR</small>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted d-block" style="font-size: 10px;">Net Result</small>
                                        <small
                                            class="text-{{ $participant->net_result >= 0 ? 'success' : 'danger' }} fw-bold">
                                            {{ $participant->net_result >= 0 ? '+' : '' }} $
                                            {{ number_format($participant->net_result, 2) }}
                                        </small>
                                    </div>
                                </div>
                            @else
                                <div class="pt-2" style="border-top: 1px solid var(--border-color);">
                                    <small class="text-warning">
                                        <i class="bi bi-info-circle me-1"></i>Waiting for admin to settle this signal
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-5 text-center">
                        <i class="bi bi-clock-history text-muted" style="font-size: 48px;"></i>
                        <p class="text-muted mt-3 mb-0">No trading history yet</p>
                        <small class="text-muted">Join signals to start trading</small>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($participants->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $participants->links() }}
                </div>
            @endif

            <!-- Info Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-info-circle-fill text-gold" style="font-size: 18px; margin-top: 2px;"></i>
                    <div>
                        <h6 class="text-white mb-1" style="font-size: 13px;">About Results</h6>
                        <ul class="small text-muted mb-0 ps-3" style="font-size: 12px;">
                            <li>P/L shows your profit or loss from the signal</li>
                            <li>Fee is 1% of your Trade Balance at settlement time</li>
                            <li>Net Result = P/L - Fee (your actual gain/loss)</li>
                            <li>Win Rate is calculated from settled signals only</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
