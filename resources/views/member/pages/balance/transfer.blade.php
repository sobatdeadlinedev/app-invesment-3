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
            <div class="row g-3 mb-4">
                <div class="col-6">
                    <div class="balance-card exchange">
                        <div class="balance-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <p class="balance-label">{{ __('app.exchange_balance') }}</p>
                        <h5 class="balance-amount">{{ number_format($exchangeBalance, 2) }}</h5>
                        <small class="balance-sublabel">USDT</small>
                    </div>
                </div>
                <div class="col-6">
                    <div class="balance-card trade">
                        <div class="balance-icon">
                            <i class="bi bi-graph-up"></i>
                        </div>
                        <p class="balance-label">{{ __('app.trade_balance') }}</p>
                        <h5 class="balance-amount">{{ number_format($tradeBalance, 2) }}</h5>
                        <small class="balance-sublabel">USDT</small>
                    </div>
                </div>
            </div>

            <!-- Transfer Form Card -->
            <div class="transfer-form-card">
                <form id="transferForm" action="" method="POST">
                    @csrf

                    <!-- From Section -->
                    <div class="form-section">
                        <label class="form-label">{{ __('app.from') }}</label>
                        <div class="select-wrapper">
                            <select class="form-select-dark" id="fromAccount" name="from_account">
                                <option value="exchange">{{ __('app.exchange_balance') }}</option>
                                <option value="trade">{{ __('app.trade_balance') }}</option>
                            </select>
                            <i class="bi bi-chevron-down select-arrow"></i>
                        </div>
                    </div>

                    <!-- Transfer To Section -->
                    <div class="form-section">
                        <label class="form-label">{{ __('app.transfer_to') }}</label>
                        <div class="select-wrapper">
                            <select class="form-select-dark" id="toAccount" name="to_account" disabled>
                                <option value="trade">{{ __('app.trade_balance') }}</option>
                            </select>
                            <i class="bi bi-chevron-down select-arrow"></i>
                        </div>
                    </div>

                    <!-- Currency Section -->
                    <div class="form-section">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label mb-0">{{ __('app.select_currency') }}</label>
                            <span class="available-balance">{{ __('app.available') }}: <span
                                    id="availableAmount">0</span></span>
                        </div>
                        <div class="currency-select-wrapper">
                            <div class="currency-option selected">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="currency-icon">
                                        <span>₮</span>
                                    </div>
                                    <span class="currency-name">USDT</span>
                                </div>
                                <i class="bi bi-check-circle-fill text-gold"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Amount Section -->
                    <div class="form-section">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label mb-0">{{ __('app.amount_of_transfers') }}</label>
                            <button type="button" class="btn-all" id="btnAll">{{ __('app.all') }}</button>
                        </div>
                        <div class="input-wrapper">
                            <input type="number" class="form-input-dark" id="transferAmount" name="amount"
                                placeholder="{{ __('app.enter_amount') }}" min="10" step="0.01" required>
                        </div>
                        <small class="text-muted d-block mt-2">{{ __('app.minimum_transfer') }}: 10.00 USDT</small>
                    </div>

                    <!-- Warning Section (if penalty applies) -->
                    <div id="penaltyWarning" class="penalty-warning" style="display: none;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                            <div>
                                <strong>{{ __('app.warning') }}:</strong> {{ __('app.penalty_warning') }}
                            </div>
                        </div>
                    </div>

                    <!-- Volume Info Section (when transferring to trade) -->
                    <div id="volumeInfo" class="info-box" style="display: none;">
                        <div class="d-flex align-items-start gap-2">
                            <i class="bi bi-info-circle-fill text-gold"></i>
                            <div>
                                <small>{{ __('app.volume_info') }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Confirm Button -->
                    <button type="submit" class="btn-confirm">
                        <i class="bi bi-check-circle me-2"></i>{{ __('app.confirm') }}
                    </button>
                </form>
            </div>

            <!-- Volume Progress Card (shown when trade balance exists) -->
            {{-- @if ($targetVolume > 0)
                <div class="volume-progress-card">
                    <h6 class="section-title">
                        <i class="bi bi-graph-up-arrow me-2"></i>{{ __('app.trading_volume_progress') }}
                    </h6>
                    <div class="volume-stats">
                        <div class="stat-item">
                            <span class="stat-label">{{ __('app.target_volume') }}</span>
                            <span class="stat-value">{{ number_format($targetVolume, 2) }} USDT</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">{{ __('app.achieved_volume') }}</span>
                            <span class="stat-value text-gold">{{ number_format($achievedVolume, 2) }} USDT</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-label">{{ __('app.remaining_volume') }}</span>
                            <span class="stat-value text-warning">{{ number_format($remainingVolume, 2) }} USDT</span>
                        </div>
                    </div>
                    <div class="progress-wrapper">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: {{ $volumePercentage }}%;"
                                aria-valuenow="{{ $volumePercentage }}" aria-valuemin="0" aria-valuemax="100">
                            </div>
                        </div>
                        <small class="progress-text">{{ number_format($volumePercentage, 2) }}%
                            {{ __('app.completed') }}</small>
                    </div>
                </div>
            @endif --}}

        </div>
    </div>

    <style>
        /* Balance Cards */
        .balance-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .balance-card:hover {
            background: rgba(255, 255, 255, 0.08);
            transform: translateY(-2px);
        }

        .balance-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 12px;
            background: rgba(245, 166, 35, 0.15);
            border: 1px solid rgba(245, 166, 35, 0.3);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .balance-card.trade .balance-icon {
            background: rgba(169, 126, 0, 0.15);
            border-color: rgba(169, 126, 0, 0.3);
        }

        .balance-icon i {
            font-size: 24px;
            color: var(--gold-color);
        }

        .balance-card.trade .balance-icon i {
            color: #a97e00;
        }

        .balance-label {
            color: var(--text-muted);
            font-size: 12px;
            margin-bottom: 8px;
        }

        .balance-amount {
            color: var(--text-white);
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .balance-sublabel {
            color: var(--text-muted);
            font-size: 11px;
        }

        /* Transfer Form Card */
        .transfer-form-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
        }

        /* Form Sections */
        .form-section {
            margin-bottom: 20px;
        }

        .form-label {
            color: var(--text-white);
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 10px;
            display: block;
        }

        /* Select Wrapper */
        .select-wrapper {
            position: relative;
        }

        .form-select-dark {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 14px 16px;
            color: var(--text-white);
            font-size: 14px;
            appearance: none;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .form-select-dark:focus {
            outline: none;
            border-color: var(--gold-color);
            background: rgba(255, 255, 255, 0.08);
        }

        .form-select-dark:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .select-arrow {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            pointer-events: none;
        }

        /* Available Balance */
        .available-balance {
            color: var(--text-muted);
            font-size: 12px;
        }

        .available-balance span {
            color: var(--gold-color);
            font-weight: 600;
        }

        /* Currency Select */
        .currency-select-wrapper {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .currency-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .currency-option:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .currency-option.selected {
            background: rgba(245, 166, 35, 0.1);
            border-left: 3px solid var(--gold-color);
        }

        .currency-icon {
            width: 32px;
            height: 32px;
            background: rgba(245, 166, 35, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .currency-icon span {
            color: var(--gold-color);
            font-size: 16px;
            font-weight: bold;
        }

        .currency-name {
            color: var(--text-white);
            font-size: 14px;
            font-weight: 500;
        }

        /* Input Wrapper */
        .input-wrapper {
            position: relative;
        }

        .form-input-dark {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 14px 16px;
            color: var(--text-white);
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-input-dark::placeholder {
            color: var(--text-muted);
            opacity: 0.5;
        }

        .form-input-dark:focus {
            outline: none;
            border-color: var(--gold-color);
            background: rgba(255, 255, 255, 0.08);
        }

        /* All Button */
        .btn-all {
            background: transparent;
            border: 1px solid var(--gold-color);
            color: var(--gold-color);
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-all:hover {
            background: rgba(245, 166, 35, 0.1);
        }

        /* Penalty Warning */
        .penalty-warning {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 16px;
            color: #ff6b6b;
            font-size: 12px;
        }

        .penalty-warning i {
            font-size: 16px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        /* Info Box */
        .info-box {
            background: rgba(245, 166, 35, 0.1);
            border: 1px solid rgba(245, 166, 35, 0.3);
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 16px;
            font-size: 12px;
        }

        .info-box i {
            font-size: 16px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .info-box small {
            color: var(--text-muted);
        }

        /* Confirm Button */
        .btn-confirm {
            width: 100%;
            background: linear-gradient(135deg, #f5a623 0%, #d4930f 100%);
            border: none;
            border-radius: 10px;
            padding: 14px;
            color: white;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(245, 166, 35, 0.3);
        }

        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(245, 166, 35, 0.4);
        }

        .btn-confirm:active {
            transform: translateY(0);
        }

        /* Volume Progress Card */
        .volume-progress-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 20px;
        }

        .section-title {
            color: var(--text-white);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
        }

        .section-title i {
            color: var(--gold-color);
        }

        .volume-stats {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 16px;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 12px;
        }

        .stat-value {
            color: var(--text-white);
            font-size: 13px;
            font-weight: 600;
        }

        .progress-wrapper {
            margin-top: 12px;
        }

        .progress {
            height: 8px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--gold-color) 0%, #f5a623 100%);
            height: 100%;
            transition: width 0.3s ease;
        }

        .progress-text {
            display: block;
            text-align: center;
            color: var(--text-muted);
            font-size: 11px;
        }

        /* Responsive */
        @media (max-width: 375px) {

            .transfer-form-card,
            .volume-progress-card {
                padding: 16px;
            }

            .balance-amount {
                font-size: 18px;
            }
        }
    </style>

    @push('scripts')
        <script>
            const exchangeBalance = {{ $exchangeBalance }};
            const tradeBalance = {{ $tradeBalance }};
            const availableTradeBalance = {{ $availableTradeBalance }};
            const needsPenalty = {{ $needsPenalty ? 'true' : 'false' }};

            // Translation strings from Laravel
            const translations = {
                exchangeBalance: "{{ __('app.exchange_balance') }}",
                tradeBalance: "{{ __('app.trade_balance') }}",
                minimumTransferAlert: "{{ __('app.minimum_transfer_alert') }}",
                insufficientBalance: "{{ __('app.insufficient_balance') }}"
            };

            const fromAccount = document.getElementById('fromAccount');
            const toAccount = document.getElementById('toAccount');
            const transferAmount = document.getElementById('transferAmount');
            const availableAmount = document.getElementById('availableAmount');
            const btnAll = document.getElementById('btnAll');
            const transferForm = document.getElementById('transferForm');
            const penaltyWarning = document.getElementById('penaltyWarning');
            const volumeInfo = document.getElementById('volumeInfo');

            // Update available balance based on selected account
            function updateAvailableBalance() {
                const from = fromAccount.value;
                let available = 0;

                if (from === 'exchange') {
                    available = exchangeBalance;
                    toAccount.innerHTML = `<option value="trade">${translations.tradeBalance}</option>`;
                    toAccount.value = 'trade';
                    penaltyWarning.style.display = 'none';
                    volumeInfo.style.display = 'block';
                    transferForm.action = "{{ route('member.balance.transfer.to-trade') }}";
                } else {
                    available = availableTradeBalance;
                    toAccount.innerHTML = `<option value="exchange">${translations.exchangeBalance}</option>`;
                    toAccount.value = 'exchange';
                    volumeInfo.style.display = 'none';
                    if (needsPenalty) {
                        penaltyWarning.style.display = 'block';
                    }
                    transferForm.action = "{{ route('member.balance.transfer.to-exchange') }}";
                }

                availableAmount.textContent = available.toFixed(2);
                transferAmount.max = available;
            }

            // Set all available balance
            btnAll.addEventListener('click', function() {
                const available = parseFloat(availableAmount.textContent);
                transferAmount.value = available.toFixed(2);
            });

            // Update on account change
            fromAccount.addEventListener('change', updateAvailableBalance);

            // Form submission confirmation
            transferForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const amount = parseFloat(transferAmount.value);
                const from = fromAccount.value;
                const to = toAccount.value;

                if (amount < 10) {
                    alert(translations.minimumTransferAlert);
                    return;
                }

                if (amount > parseFloat(availableAmount.textContent)) {
                    alert(translations.insufficientBalance);
                    return;
                }

                let message = `Transfer ${amount.toFixed(2)} USDT from ${from.toUpperCase()} to ${to.toUpperCase()}?`;

                if (from === 'trade' && needsPenalty) {
                    const penalty = amount * 0.20;
                    const net = amount - penalty;
                    message = `{{ __('app.warning') }}: 20% Penalty will be applied!\n\n` +
                        `Transfer Amount: ${amount.toFixed(2)} USDT\n` +
                        `Penalty (20%): ${penalty.toFixed(2)} USDT\n` +
                        `You will receive: ${net.toFixed(2)} USDT\n\n` +
                        `Do you want to continue?`;
                }

                if (confirm(message)) {
                    this.submit();
                }
            });

            // Initialize
            updateAvailableBalance();

            // Auto hide alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 300);
                });
            }, 5000);
        </script>
    @endpush
@endsection
