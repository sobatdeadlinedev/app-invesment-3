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

            <!-- Balance Summary Cards -->
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <div class="card-dark shadow-sm p-3">
                        <p class="text-muted mb-1 small">Exchange Balance</p>
                        <h5 class="text-gold mb-0 fw-bold">$ {{ number_format($exchangeBalance, 2) }}</h5>
                        <small class="text-muted">For Withdrawal</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card-dark shadow-sm p-3">
                        <p class="text-muted mb-1 small">Trade Balance</p>
                        <h5 class="text-success mb-0 fw-bold">$ {{ number_format($tradeBalance, 2) }}</h5>
                        <small class="text-muted">For Trading</small>
                    </div>
                </div>
            </div>

            <!-- Locked Balance Info -->
            @if ($lockedBalance > 0)
                <div class="card-dark shadow-sm p-3 mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Locked Balance</p>
                            <h6 class="text-warning mb-0 fw-bold">$ {{ number_format($lockedBalance, 2) }}</h6>
                        </div>
                        <div class="text-end">
                            <p class="text-muted mb-1 small">Available Trade</p>
                            <h6 class="text-white mb-0 fw-bold">$ {{ number_format($availableTradeBalance, 2) }}</h6>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Volume Progress Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <h6 class="text-white mb-3">Trading Volume Progress</h6>
                <div class="mb-2">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Target Volume</span>
                        <span class="text-white fw-bold">$ {{ number_format($targetVolume, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Achieved Volume</span>
                        <span class="text-success fw-bold">$ {{ number_format($achievedVolume, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted small">Remaining Volume</span>
                        <span class="text-warning fw-bold">$ {{ number_format($remainingVolume, 2) }}</span>
                    </div>
                    <div class="progress" style="height: 8px; background-color: var(--border-color);">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $volumePercentage }}%;"
                            aria-valuenow="{{ $volumePercentage }}" aria-valuemin="0" aria-valuemax="100">
                        </div>
                    </div>
                    <div class="text-center mt-2">
                        <small class="text-muted">{{ number_format($volumePercentage, 2) }}% Completed</small>
                    </div>
                </div>
            </div>

            <!-- Transfer Exchange to Trade -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <h6 class="text-white mb-3">
                    <i class="bi bi-arrow-right-circle text-gold me-2"></i>Transfer to Trade Balance
                </h6>
                <form action="{{ route('member.balance.transfer.to-trade') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="text-muted small mb-2 d-block">Amount (USDT)</label>
                        <input type="number" name="amount" class="form-control-dark" placeholder="Enter amount"
                            min="10" step="0.01" required>
                        <small class="text-muted">Minimum: $ 10.00</small>
                    </div>

                    <div class="alert"
                        style="background-color: rgba(245, 166, 35, 0.1); border: 1px solid #f5a623; color: #f5a623; font-size: 12px;">
                        <i class="bi bi-info-circle me-2"></i>
                        This transfer will increase your trading volume target by the same amount.
                    </div>

                    <button type="submit" class="btn btn-call w-100">
                        <i class="bi bi-arrow-right me-2"></i>Transfer to Trade
                    </button>
                </form>
            </div>

            <!-- Transfer Trade to Exchange -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <h6 class="text-white mb-3">
                    <i class="bi bi-arrow-left-circle text-danger me-2"></i>Transfer to Exchange Balance
                </h6>
                <form action="{{ route('member.balance.transfer.to-exchange') }}" method="POST"
                    onsubmit="return confirmTransferToExchange()">
                    @csrf
                    <div class="mb-3">
                        <label class="text-muted small mb-2 d-block">Amount (USDT)</label>
                        <input type="number" name="amount" id="transferAmount" class="form-control-dark"
                            placeholder="Enter amount" min="10" step="0.01" max="{{ $availableTradeBalance }}"
                            required>
                        <small class="text-muted">Available: $ {{ number_format($availableTradeBalance, 2) }}</small>
                    </div>

                    @if ($needsPenalty)
                        <div class="alert alert-danger" style="font-size: 12px;">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Warning:</strong> Your trading volume is not completed yet.
                            A <strong>20% penalty</strong> will be applied to this transfer.
                        </div>
                    @endif

                    <button type="submit" class="btn btn-put w-100">
                        <i class="bi bi-arrow-left me-2"></i>Transfer to Exchange
                    </button>
                </form>
            </div>

            <!-- Info Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-info-circle-fill text-gold" style="font-size: 18px; margin-top: 2px;"></i>
                    <div>
                        <h6 class="text-white mb-1" style="font-size: 13px;">Important Information</h6>
                        <ul class="small text-muted mb-0 ps-3" style="font-size: 12px;">
                            <li>Exchange Balance is for deposits, withdrawals, and commissions</li>
                            <li>Trade Balance is for trading activities</li>
                            <li>Transferring to Trade Balance creates trading volume obligations</li>
                            <li>20% penalty applies if volume target is not met when transferring back</li>
                            <li>Complete your trading volume to avoid penalties</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('scripts')
        <script>
            function confirmTransferToExchange() {
                const amount = document.getElementById('transferAmount').value;
                @if ($needsPenalty)
                    const penalty = amount * 0.20;
                    const net = amount - penalty;
                    return confirm(
                        `WARNING: 20% Penalty will be applied!\n\n` +
                        `Transfer Amount: $${parseFloat(amount).toFixed(2)}\n` +
                        `Penalty (20%): $${penalty.toFixed(2)}\n` +
                        `You will receive: $${net.toFixed(2)}\n\n` +
                        `Do you want to continue?`
                    );
                @else
                    return confirm(`Transfer $${parseFloat(amount).toFixed(2)} to Exchange Balance?`);
                @endif
            }

            // Auto hide alerts
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        </script>
    @endpush
@endsection
