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
            <div class="mb-3">
                <h6 class="text-white mb-3">Trading History</h6>

                @forelse($participants as $participant)
                    @php
                        $signal = $participant->signal;
                        $coinInfo = $signal->getCoinInfo();

                        // Check if signal is pending
                        $isPending = $signal->result === 'pending' || $signal->result === null;

                        // FIXED: Determine win/loss based on signal result, not profit_loss
                        $isWin = $signal->result === 'win';
                        $isSettled = $participant->status === 'settled';

                        // Calculate display values
                        $profitLossAmount = $participant->profit_loss ?? 0;
                        $feeAmount = $participant->fee_amount ?? 0;
                        $netResult = $profitLossAmount - $feeAmount;

                        // Determine if final result is positive (after fees)
                        $isFinalProfit = $netResult > 0;
                    @endphp

                    <div class="card-dark shadow-sm p-3 mb-3">
                        <!-- Header -->
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <!-- Badge shows signal title -->
                                <span
                                    class="badge {{ $signal->result === 'win' ? 'badge-success' : ($signal->result === 'loss' ? 'badge-danger' : 'badge-warning') }}"
                                    style="font-size: 11px; padding: 6px 12px;">
                                    {{ strtoupper($signal->title ?? 'SIGNAL') }}
                                </span>
                                <span class="text-white fw-bold">{{ $coinInfo['symbol'] }}</span>
                            </div>

                            <!-- Right side: CALL/PUT text only -->
                            @php
                                // Tentukan CALL atau PUT berdasarkan result
                                $direction = '';
                                $textColor = 'text-muted';

                                if ($isPending) {
                                    $direction = 'PENDING';
                                    $textColor = 'text-warning';
                                } elseif ($signal->result === 'win') {
                                    $direction = 'CALL';
                                    $textColor = 'text-success';
                                } elseif ($signal->result === 'loss') {
                                    $direction = 'PUT';
                                    $textColor = 'text-danger';
                                }
                            @endphp

                            <span class="fw-bold {{ $textColor }}" style="font-size: 12px;">
                                {{ $direction }}
                            </span>
                        </div>

                        <!-- Details -->
                        <div class="d-flex flex-column gap-2">
                            <!-- Time Period -->
                            <div class="d-flex justify-content-between">
                                <span class="text-muted" style="font-size: 12px;">time period</span>
                                <span class="text-white" style="font-size: 12px;">
                                    @if ($isPending)
                                        ~
                                    @else
                                        {{ $signal->opened_at ? $signal->opened_at->format('H:i:s') : '-' }} -
                                        {{ $signal->closed_at ? $signal->closed_at->format('H:i:s') : '-' }}
                                    @endif
                                </span>
                            </div>

                            <!-- Fee Amount -->
                            @if (!$isPending && $isSettled && $feeAmount > 0)
                                <div class="d-flex justify-content-between">
                                    <span class="text-muted" style="font-size: 12px;">trading fee (1%)</span>
                                    <span class="text-warning" style="font-size: 12px;">
                                        -{{ number_format($feeAmount, 2) }}
                                    </span>
                                </div>
                            @endif

                            <!-- Net Result (after fee) -->
                            <div class="d-flex justify-content-between">
                                <span class="text-muted" style="font-size: 12px;">net profit/loss</span>
                                <span class="text-{{ $isFinalProfit ? 'success' : 'danger' }} fw-bold"
                                    style="font-size: 12px;">
                                    @if ($isPending)
                                        ~
                                    @else
                                        {{ $isSettled ? ($netResult >= 0 ? '+' : '') . number_format($netResult, 2) : '-' }}
                                    @endif
                                </span>
                            </div>

                            <!-- Rate of Return -->
                            <div class="d-flex justify-content-between">
                                <span class="text-muted" style="font-size: 12px;">rate of return</span>
                                <span class="text-white" style="font-size: 12px;">
                                    @if ($isPending)
                                        ~
                                    @else
                                        {{ $isSettled ? number_format($signal->rate_of_return, 2) . '%' : '-' }}
                                    @endif
                                </span>
                            </div>

                            <!-- Order Quantity -->
                            <div class="d-flex justify-content-between">
                                <span class="text-muted" style="font-size: 12px;">order quantity</span>
                                <span class="text-white" style="font-size: 12px;">
                                    {{ number_format($participant->bet_amount, 2) }}
                                </span>
                            </div>

                            <!-- Opening Price -->
                            <div class="d-flex justify-content-between">
                                <span class="text-muted" style="font-size: 12px;">opening price</span>
                                <span class="text-white" style="font-size: 12px;">
                                    @if ($isPending)
                                        ~
                                    @else
                                        {{ number_format($signal->entry_price, 3) }}
                                    @endif
                                </span>
                            </div>

                            <!-- Settlement Price -->
                            <div class="d-flex justify-content-between">
                                <span class="text-muted" style="font-size: 12px;">settlement price</span>
                                <span class="text-white" style="font-size: 12px;">
                                    @if ($isPending)
                                        ~
                                    @else
                                        {{ $isSettled ? number_format($signal->target_price, 3) : '-' }}
                                    @endif
                                </span>
                            </div>

                            <!-- Order Time -->
                            <div class="d-flex justify-content-between">
                                <span class="text-muted" style="font-size: 12px;">order time</span>
                                <span class="text-white" style="font-size: 12px;">
                                    {{ $participant->joined_at->format('Y-m-d H:i:s') }}
                                </span>
                            </div>

                            @if ($isPending)
                                <!-- Pending Notice -->
                                <div class="mt-2 pt-2" style="border-top: 1px solid var(--border-color);">
                                    <small class="text-warning">
                                        <i class="bi bi-info-circle me-1"></i>Waiting for admin to settle this signal
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="card-dark shadow-sm p-5 text-center">
                        <i class="bi bi-clock-history text-muted" style="font-size: 48px;"></i>
                        <p class="text-muted mt-3 mb-0">No trading history yet</p>
                        <small class="text-muted">Join signals to start trading</small>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($participants->hasPages())
                <div class="d-flex justify-content-center mb-3">
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
                            <li>Signal result (WIN/LOSS) is determined by admin</li>
                            <li>Gross P/L = Your profit/loss before fees</li>
                            <li>Trading Fee = 1% of your bet amount (deducted on win only)</li>
                            <li>Net P/L = Final result after deducting fees</li>
                            <li>Win Rate is calculated from settled signals only</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
