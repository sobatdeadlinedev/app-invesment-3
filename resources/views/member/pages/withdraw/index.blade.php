@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section" style="padding: 0;">

            <!-- Header with Back & History Buttons -->
            <div class="seamless-header-nav">
                <a href="{{ route('member.profile.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
                <a href="{{ route('member.withdraw.history') }}" class="btn-history">
                    <i class="bi bi-clock-history me-1"></i>History
                </a>
            </div>

            <!-- Page Title -->
            <div class="seamless-page-title">
                <h5 class="mb-0 fw-bold" style="color: var(--text-primary);">Withdraw</h5>
            </div>

            <!-- Currency Info -->
            <div class="seamless-currency-info">
                <div class="d-flex align-items-center gap-2">
                    <div class="currency-icon-wrapper">
                        <span style="color: var(--gold-color); font-size: 20px; font-weight: bold;">₮</span>
                    </div>
                    <div>
                        <p class="text-muted mb-0 small">Currency</p>
                        <h6 class="mb-0 fw-bold" style="color: var(--text-primary);">USDT (Tether)</h6>
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
                            <h6 class="mb-1 fw-bold" style="font-size: 14px; color: #ffc107;">Akun Belum Terverifikasi</h6>
                            <p class="small mb-0" style="font-size: 13px; color: var(--text-primary);">
                                Akun Anda belum terverifikasi. Untuk melakukan verifikasi akun kunjungi profile dan klik
                                verifikasi akun.
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
                            <p class="text-muted mb-1 small">Available Balance</p>
                            <h5 class="text-gold mb-0 fw-bold">{{ number_format($userBalance, 2) }} USDT</h5>
                        </div>
                        <div class="balance-icon-wrapper">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                </div>

                <!-- Withdrawal Amount Section -->
                <div class="seamless-input-section">
                    <h6 class="mb-3 fw-bold" style="color: var(--text-primary); font-size: 14px;">Withdrawal Amount</h6>
                    <div class="mb-3">
                        <label class="text-muted small mb-2 d-block">Amount (USDT)</label>
                        <div class="input-with-icon">
                            <span class="input-icon">₮</span>
                            <input type="number" name="amount" id="withdraw-amount" class="form-control-dark with-icon"
                                placeholder="Enter amount" value="{{ old('amount') }}" step="0.01" min="20"
                                {{ !auth()->user()->is_verified ? 'disabled' : 'required' }}>
                        </div>
                        <small class="text-muted d-block mt-1">Minimum withdrawal: 20 USDT | Fee: 5 USDT (< 100 USDT) or 5%
                                (≥ 100 USDT)</small>
                                @error('amount')
                                    <small class="text-danger mt-1 d-block">{{ $message }}</small>
                                @enderror
                    </div>
                </div>

                <!-- Select Wallet Account Section -->
                <div class="seamless-wallet-section">
                    <h6 class="mb-3 fw-bold" style="color: var(--text-primary); font-size: 14px;">Select Wallet Account</h6>
                    <div>
                        <label class="text-muted small mb-2 d-block">Choose your wallet account</label>
                        <select name="wallet_id" id="wallet-account" class="form-control-dark-select"
                            {{ !auth()->user()->is_verified || $wallets->isEmpty() ? 'disabled' : 'required' }}>
                            <option value="">-- Select Wallet Account --</option>
                            @forelse($wallets as $wallet)
                                <option value="{{ $wallet->id }}" {{ old('wallet_id') == $wallet->id ? 'selected' : '' }}>
                                    {{ $wallet->account_number }} - {{ $wallet->type }}
                                </option>
                            @empty
                                <option value="" disabled>No wallet account available</option>
                            @endforelse
                        </select>
                        @error('wallet_id')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror

                        @if ($wallets->isEmpty())
                            <div class="alert-info-box mt-2">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                <span class="small">You need to add a wallet account first. <a
                                        href="{{ route('member.profile.index') }}" class="text-gold"
                                        style="text-decoration: underline;">Add Wallet</a></span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Fee Calculation -->
                <div class="seamless-summary-section" id="fee-card" style="display: none;">
                    <h6 class="mb-3 fw-bold" style="color: var(--text-primary); font-size: 14px;">Withdrawal Summary</h6>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Withdrawal Amount</span>
                        <span class="fw-bold" style="color: var(--text-primary);" id="display-amount">0.00 USDT</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">Withdrawal Fee</span>
                        <span class="fw-bold" style="color: var(--text-primary);" id="display-fee">0.00 USDT</span>
                    </div>
                    <hr style="border-color: var(--border-color);">
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold" style="color: var(--text-primary);">You will receive</span>
                        <span class="text-gold fw-bold" id="display-total">0.00 USDT</span>
                    </div>
                </div>

                <!-- Info Section -->
                <div class="seamless-info-section">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-info-circle-fill text-gold"
                            style="font-size: 18px; margin-top: 2px; flex-shrink: 0;"></i>
                        <div>
                            <h6 class="mb-1 fw-bold" style="font-size: 13px; color: var(--text-primary);">Withdrawal
                                Information</h6>
                            <p class="small text-muted mb-0" style="font-size: 12px;">
                                Withdrawal akan diproses dalam 1-3 hari kerja. Pastikan data wallet Anda sudah benar.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="seamless-action-section">
                    <button type="button" class="btn btn-gold w-100" onclick="submitWithdraw()"
                        {{ !auth()->user()->is_verified || $wallets->isEmpty() ? 'disabled' : '' }}>
                        Submit Withdrawal
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
                    alert('Akun Anda belum terverifikasi. Silakan hubungi admin untuk verifikasi akun.');
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
                    alert('Akun Anda belum terverifikasi. Withdrawal tidak dapat diproses. Silakan hubungi admin.');
                    return;
                }

                const amount = parseFloat(document.getElementById('withdraw-amount').value);
                const walletSelect = document.getElementById('wallet-account');

                if (!amount || amount <= 0) {
                    alert('Please enter a valid amount');
                    return;
                }

                if (amount < 20) {
                    alert('Minimum withdrawal amount is 20 USDT');
                    return;
                }

                if (amount > userBalance) {
                    alert('Insufficient balance. Your available balance is ' + userBalance.toFixed(2) + ' USDT');
                    return;
                }

                if (!walletSelect.value) {
                    alert('Please select a wallet account');
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
                    alert('Amount too small. After fee deduction, you will receive 0 USDT or less.');
                    return;
                }

                // Confirm before submit
                if (confirm('Confirm withdrawal?\n\nAmount: ' + amount.toFixed(2) + ' USDT\nFee: ' + fee.toFixed(2) +
                        ' USDT\nYou will receive: ' + total.toFixed(2) + ' USDT')) {
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
