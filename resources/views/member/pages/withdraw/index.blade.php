@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section" style="padding: 0;">

            <!-- Header with Back & History Buttons -->
            <div class="seamless-header-nav">
                <a href="{{ route('member.profile.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('app.back') }}
                </a>
                <a href="{{ route('member.withdraw.history') }}" class="btn-history">
                    <i class="bi bi-clock-history me-1"></i>{{ __('app.history') }}
                </a>
            </div>

            <!-- Page Title -->
            <div class="seamless-page-title">
                <h5 class="mb-0 fw-bold" style="color: var(--text-primary);">{{ __('app.withdraw') }}</h5>
            </div>

            <!-- Currency Info -->
            <div class="seamless-currency-info">
                <div class="d-flex align-items-center gap-2">
                    <div class="currency-icon-wrapper">
                        <span style="color: var(--gold-color); font-size: 20px; font-weight: bold;">₮</span>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">{{ __('app.currency') }}</p>
                        <h6 class="mb-0 fw-bold" style="color: var(--text-primary);">{{ __('app.usdt_tether') }}</h6>
                    </div>
                </div>
            </div>

            <!-- Verification Alert (if not verified) -->
            @if (!auth()->user()->is_verified)
                <div class="seamless-alert seamless-alert-warning">
                    <div class="d-flex align-items-start gap-3">
                        <div class="warning-icon-wrapper">
                            <i class="bi bi-exclamation-triangle-fill"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1 fw-bold" style="font-size: 14px; color: #ffc107;">
                                {{ __('app.account_not_verified') }}</h6>
                            <p class="small mb-0" style="font-size: 13px; color: var(--text-primary);">
                                {{ __('app.account_not_verified_message') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <form id="withdraw-form" action="{{ route('member.withdraw.store') }}" method="POST">
                @csrf

                <!-- Current Balance Info -->
                <div class="seamless-balance-info">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">{{ __('app.available_balance') }}</p>
                            <h5 class="text-gold mb-0 fw-bold">{{ number_format($userBalance, 2) }} USDT</h5>
                        </div>
                        <div class="balance-icon-wrapper">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                </div>

                <!-- Withdrawal Amount Section -->
                <div class="seamless-input-section">
                    <h6 class="mb-3 fw-bold" style="color: var(--text-primary); font-size: 14px;">
                        {{ __('app.withdrawal_amount') }}</h6>
                    <div class="mb-3">
                        <label class="text-muted small mb-2 d-block">{{ __('app.amount_usdt') }}</label>
                        <div class="input-with-icon">
                            <span class="input-icon">₮</span>
                            <input type="number" name="amount" id="withdraw-amount" class="form-control-dark with-icon"
                                placeholder="{{ __('app.enter_amount') }}" value="{{ old('amount') }}" step="0.01"
                                min="20" {{ !auth()->user()->is_verified ? 'disabled' : 'required' }}>
                        </div>
                        <small class="text-muted d-block mt-1">{{ __('app.minimum_withdrawal_info') }}</small>
                        @error('amount')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <!-- Select Wallet Account Section -->
                <div class="seamless-wallet-section">
                    <h6 class="mb-3 fw-bold" style="color: var(--text-primary); font-size: 14px;">
                        {{ __('app.select_wallet_account') }}</h6>
                    <div>
                        <label class="text-muted small mb-2 d-block">{{ __('app.choose_wallet_account') }}</label>
                        <select name="wallet_id" id="wallet-account" class="form-control-dark-select"
                            {{ !auth()->user()->is_verified || $wallets->isEmpty() ? 'disabled' : 'required' }}>
                            <option value="">{{ __('app.select_wallet_placeholder') }}</option>
                            @forelse($wallets as $wallet)
                                <option value="{{ $wallet->id }}"
                                    {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                                    {{ $wallet->account_number }} - {{ $wallet->type }}
                                </option>
                            @empty
                                <option value="" disabled>{{ __('app.no_wallet_available') }}</option>
                            @endforelse
                        </select>
                        @error('wallet_id')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror

                        
                    </div>
                </div>

                <!-- Fee Calculation -->
                <div class="seamless-summary-section" id="fee-card" style="display: none;">
                    <h6 class="mb-3 fw-bold" style="color: var(--text-primary); font-size: 14px;">
                        {{ __('app.withdrawal_summary') }}</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('app.withdrawal_amount') }}</span>
                        <span class="fw-bold" style="color: var(--text-primary);" id="display-amount">0.00 USDT</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('app.withdrawal_fee') }}</span>
                        <span class="fw-bold" style="color: var(--text-primary);" id="display-fee">0.00 USDT</span>
                    </div>
                    <hr style="border-color: var(--border-color);">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold" style="color: var(--text-primary);">{{ __('app.you_will_receive') }}</span>
                        <span class="text-gold fw-bold" id="display-total">0.00 USDT</span>
                    </div>
                </div>

                {{-- <!-- Info Section -->
                <div class="seamless-info-section">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-info-circle-fill text-gold"
                            style="font-size: 18px; margin-top: 2px; flex-shrink: 0;"></i>
                        <div>
                            <h6 class="mb-1 fw-bold" style="font-size: 13px; color: var(--text-primary);">
                                {{ __('app.withdrawal_information') }}</h6>
                            <p class="small text-muted mb-0" style="font-size: 12px;">
                                {{ __('app.withdrawal_process_info') }}
                            </p>
                        </div>
                    </div>
                </div> --}}

                <!-- Submit Button -->
                <div class="seamless-action-section">
                    <button type="button" class="btn btn-gold w-100" onclick="submitWithdraw()"
                        {{ !auth()->user()->is_verified || $wallets->isEmpty() ? 'disabled' : '' }}>
                        {{ __('app.submit_withdrawal') }}
                    </button>
                </div>
            </form>

        </div>
    </div>

    @push('styles')
        <style>
            /* Seamless Header Nav */
            .seamless-header-nav {
                padding: 20px;
                background: transparent;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            /* History Button Style */
            .btn-history {
                display: inline-flex;
                align-items: center;
                padding: 8px 16px;
                background: rgba(169, 126, 0, 0.1);
                border: 1px solid rgba(169, 126, 0, 0.3);
                border-radius: 8px;
                color: var(--gold-color);
                font-size: 13px;
                font-weight: 600;
                text-decoration: none;
                transition: all 0.2s ease;
            }

            .btn-history:hover {
                background: rgba(169, 126, 0, 0.2);
                border-color: var(--gold-color);
                color: var(--gold-color);
                text-decoration: none;
            }

            .btn-history i {
                font-size: 14px;
            }

            /* Seamless Page Title */
            .seamless-page-title {
                padding: 0 20px 16px 20px;
                background: transparent;
            }

            /* Seamless Currency Info */
            .seamless-currency-info {
                padding: 20px;
                background: transparent;
            }

            .currency-icon-wrapper {
                width: 40px;
                height: 40px;
                background: rgba(169, 126, 0, 0.1);
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            /* Seamless Alert Warning */
            .seamless-alert-warning {
                padding: 16px 20px;
                background: rgba(255, 193, 7, 0.05);
            }

            .seamless-alert-warning .warning-icon-wrapper {
                width: 40px;
                height: 40px;
                background: rgba(255, 193, 7, 0.15);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .seamless-alert-warning .warning-icon-wrapper i {
                font-size: 20px;
                color: #ffc107;
            }

            /* Seamless Balance Info */
            .seamless-balance-info {
                padding: 20px;
                background: rgba(169, 126, 0, 0.05);
            }

            /* Seamless Input Section */
            .seamless-input-section {
                padding: 20px;
                background: transparent;
            }

            /* Seamless Wallet Section */
            .seamless-wallet-section {
                padding: 20px;
                background: transparent;
            }

            /* Seamless Summary Section */
            .seamless-summary-section {
                padding: 20px;
                background: rgba(169, 126, 0, 0.05);
            }

            /* Seamless Info Section */
            .seamless-info-section {
                padding: 20px;
                background: transparent;
            }

            /* Seamless Action Section */
            .seamless-action-section {
                padding: 20px;
                background: transparent;
            }

            /* Improved Dropdown Styling */
            .form-control-dark-select {
                background: rgba(169, 126, 0, 0.05);
                border: 1px solid var(--border-color);
                border-radius: 8px;
                padding: 12px 16px;
                color: var(--text-primary);
                font-size: 14px;
                font-weight: 600;
                width: 100%;
                transition: all 0.2s ease;
                appearance: none;
                -webkit-appearance: none;
                -moz-appearance: none;
                background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23A97E00' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
                background-repeat: no-repeat;
                background-position: right 12px center;
                background-size: 16px;
                padding-right: 40px;
            }

            .form-control-dark-select:focus {
                outline: none;
                border-color: var(--gold-color);
                background-color: rgba(169, 126, 0, 0.1);
                box-shadow: 0 0 0 3px rgba(169, 126, 0, 0.1);
            }

            .form-control-dark-select.is-invalid {
                border-color: #dc3545;
            }

            .form-control-dark-select option {
                background-color: #FFFFFF !important;
                color: var(--text-primary) !important;
                padding: 12px;
                font-size: 14px;
            }

            .form-control-dark-select option:hover {
                background-color: rgba(169, 126, 0, 0.1) !important;
            }

            .form-control-dark-select option:checked {
                background: linear-gradient(135deg, var(--gold-color) 0%, var(--gold-hover) 100%) !important;
                color: #fff !important;
                font-weight: 700;
            }

            .form-control-dark-select option[value=""] {
                color: var(--text-muted) !important;
            }

            .form-control-dark-select:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            /* Alert info box */
            .alert-info-box {
                background: rgba(169, 126, 0, 0.1);
                border: 1px solid rgba(169, 126, 0, 0.3);
                border-radius: 8px;
                padding: 12px;
                display: flex;
                align-items: flex-start;
                color: var(--gold-color);
            }

            .alert-info-box i {
                flex-shrink: 0;
                margin-top: 2px;
            }

            .alert-info-box .small {
                line-height: 1.5;
            }

            /* Disabled state for quick amount buttons */
            .quick-amount-btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }

            /* Better dropdown for mobile */
            @media (max-width: 480px) {
                .form-control-dark-select {
                    font-size: 16px;
                }
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            const userBalance = {{ $userBalance }};
            const isVerified = {{ auth()->user()->is_verified ? 'true' : 'false' }};

            // Translation strings from Laravel
            const translations = {
                accountNotVerifiedAlert: "{{ __('app.account_not_verified_alert') }}",
                withdrawalNotProcessed: "{{ __('app.withdrawal_not_processed') }}",
                enterValidAmount: "{{ __('app.enter_valid_amount') }}",
                minimumWithdrawal20: "{{ __('app.minimum_withdrawal_20') }}",
                insufficientBalance: "{{ __('app.insufficient_balance_withdraw') }}",
                pleaseSelectWallet: "{{ __('app.please_select_wallet') }}",
                amountTooSmall: "{{ __('app.amount_too_small') }}",
                confirmWithdrawal: "{{ __('app.confirm_withdrawal') }}"
            };

            // Show alert messages
            @if (session('success'))
                alert('{{ session('success') }}');
            @endif

            @if (session('error'))
                alert('{{ session('error') }}');
            @endif

            @if ($errors->any())
                alert('{{ $errors->first() }}');
            @endif

            function setWithdrawAmount(amount) {
                if (!isVerified) {
                    alert(translations.accountNotVerifiedAlert);
                    return;
                }
                document.getElementById('withdraw-amount').value = amount;
                calculateFee();
            }

            // Calculate fee when amount changes
            document.getElementById('withdraw-amount').addEventListener('input', function() {
                calculateFee();
            });

            function calculateFee() {
                const amount = parseFloat(document.getElementById('withdraw-amount').value) || 0;

                if (amount > 0) {
                    // FEE LOGIC: 5 USDT for < 100, 5% for >= 100
                    let fee;
                    if (amount < 100) {
                        fee = 5; // Fixed 5 USDT for amounts below 100
                    } else {
                        fee = amount * 0.05; // 5% for amounts 100 and above
                    }

                    const total = amount - fee;

                    document.getElementById('display-amount').textContent = amount.toFixed(2) + ' USDT';
                    document.getElementById('display-fee').textContent = fee.toFixed(2) + ' USDT';
                    document.getElementById('display-total').textContent = total.toFixed(2) + ' USDT';
                    document.getElementById('fee-card').style.display = 'block';
                } else {
                    document.getElementById('fee-card').style.display = 'none';
                }
            }

            function submitWithdraw() {
                if (!isVerified) {
                    alert(translations.withdrawalNotProcessed);
                    return;
                }

                const amount = parseFloat(document.getElementById('withdraw-amount').value);
                const walletSelect = document.getElementById('wallet-account');

                if (!amount || amount <= 0) {
                    alert(translations.enterValidAmount);
                    return;
                }

                if (amount < 20) {
                    alert(translations.minimumWithdrawal20);
                    return;
                }

                if (amount > userBalance) {
                    alert(translations.insufficientBalance.replace(':balance', userBalance.toFixed(2)));
                    return;
                }

                if (!walletSelect.value) {
                    alert(translations.pleaseSelectWallet);
                    return;
                }

                // FEE CALCULATION: 5 USDT for < 100, 5% for >= 100
                let fee;
                if (amount < 100) {
                    fee = 5; // Fixed 5 USDT
                } else {
                    fee = amount * 0.05; // 5%
                }

                const total = amount - fee;

                if (total <= 0) {
                    alert(translations.amountTooSmall);
                    return;
                }

                // Confirm before submit
                const confirmMessage = translations.confirmWithdrawal
                    .replace(':amount', amount.toFixed(2))
                    .replace(':fee', fee.toFixed(2))
                    .replace(':total', total.toFixed(2));

                if (confirm(confirmMessage)) {
                    document.getElementById('withdraw-form').submit();
                }
            }

            // Enhanced dropdown behavior
            document.getElementById('wallet-account').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];

                // Visual feedback when wallet is selected
                if (this.value) {
                    this.style.borderColor = 'var(--gold-color)';
                    this.style.backgroundColor = 'rgba(169, 126, 0, 0.1)';
                } else {
                    this.style.borderColor = 'var(--border-color)';
                    this.style.backgroundColor = 'rgba(169, 126, 0, 0.05)';
                }
            });

            // Auto-select first wallet if only one available and no previous selection
            window.addEventListener('DOMContentLoaded', function() {
                if (!isVerified) return; // Skip auto-select if not verified

                const walletSelect = document.getElementById('wallet-account');
                const options = walletSelect.querySelectorAll('option[value]:not([value=""])');

                // If only one wallet available and nothing selected, auto-select it
                if (options.length === 1 && !walletSelect.value) {
                    walletSelect.value = options[0].value;
                    walletSelect.dispatchEvent(new Event('change'));
                }
            });
        </script>
    @endpush
@endsection
