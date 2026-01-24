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
                <a href="{{ route('member.deposit.history') }}" class="btn-history">
                    <i class="bi bi-clock-history me-1"></i>History
                </a>
            </div>

            <!-- Page Title -->
            <div class="seamless-page-title">
                <h5 class="mb-0 fw-bold" style="color: var(--text-primary);">Deposit</h5>
            </div>

            <!-- Step Indicator -->
            <div class="seamless-step-wrapper">
                <div class="step-indicator">
                    <div class="step-item active" id="step-1-indicator">
                        <div class="step-circle">1</div>
                        <div class="step-label">Amount</div>
                    </div>
                    <div class="step-line"></div>
                    <div class="step-item" id="step-2-indicator">
                        <div class="step-circle">2</div>
                        <div class="step-label">Payment</div>
                    </div>
                </div>
            </div>

            <!-- Step 1: Amount -->
            <div id="step-1" class="step-content active">

                <!-- Current Balance Info -->
                <div class="seamless-balance-info">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Current Balance</p>
                            <h5 class="text-gold mb-0 fw-bold">{{ number_format($userBalance, 2) }} USDT</h5>
                        </div>
                        <div class="balance-icon-wrapper">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                </div>

                <!-- Amount Input Section -->
                <div class="seamless-input-section">
                    <h6 class="mb-3 fw-bold" style="color: var(--text-primary); font-size: 14px;">Deposit Amount</h6>
                    <div class="mb-3">
                        <label class="text-muted small mb-2 d-block">Enter Amount (USDT)</label>
                        <div class="input-with-icon">
                            <span class="input-icon">₮</span>
                            <input type="number" id="deposit-amount" class="form-control-dark with-icon"
                                placeholder="Enter amount manually" value="" step="0.01" min="10">
                        </div>
                        <small class="text-muted d-block mt-1">Minimum deposit: 10 USDT</small>
                    </div>
                </div>

                <!-- Wallet Type Selection -->
                <div class="seamless-wallet-section">
                    <h6 class="mb-3 fw-bold" style="color: var(--text-primary); font-size: 14px;">Select Network</h6>
                    <div class="wallet-type-selection">
                        <div class="wallet-type-option" onclick="selectWalletType('trc20')">
                            <input type="radio" name="wallet_type_display" id="wallet-trc20" value="trc20" checked>
                            <label for="wallet-trc20" class="wallet-type-label">
                                <div class="wallet-type-header">
                                    <i class="bi bi-circle-fill me-2"></i>
                                    <span class="fw-bold">TRC20</span>
                                </div>
                                <div class="wallet-type-details">
                                    <small class="text-muted">TRON Network</small>
                                </div>
                            </label>
                        </div>

                        <div class="wallet-type-option" onclick="selectWalletType('bep20')">
                            <input type="radio" name="wallet_type_display" id="wallet-bep20" value="bep20">
                            <label for="wallet-bep20" class="wallet-type-label">
                                <div class="wallet-type-header">
                                    <i class="bi bi-circle-fill me-2"></i>
                                    <span class="fw-bold">BEP20</span>
                                </div>
                                <div class="wallet-type-details">
                                    <small class="text-muted">Binance Smart Chain</small>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Continue Button -->
                <div class="seamless-action-section">
                    <button class="btn btn-gold w-100" type="button" onclick="goToStep2()">
                        Continue <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </div>

            <!-- Step 2: Payment Method -->
            <div id="step-2" class="step-content">
                <form id="deposit-form" action="{{ route('member.deposit.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="amount" id="form-amount">
                    <input type="hidden" name="wallet_type" id="form-wallet-type" value="trc20">

                    <!-- Amount Summary -->
                    <div class="seamless-summary-section">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="text-muted mb-0">Deposit Amount</p>
                            <h5 class="text-gold mb-0 fw-bold" id="summary-amount">100.00 USDT</h5>
                        </div>
                    </div>

                    <!-- Payment Details: E-Wallet -->
                    <div class="seamless-payment-section">
                        <h6 class="mb-3 fw-bold" style="color: var(--text-primary); font-size: 14px;">Transfer USDT to
                            E-Wallet</h6>

                        <!-- Jaringan -->
                        <div class="payment-info-item">
                            <div class="payment-info-row">
                                <span class="text-muted small payment-label">Jaringan</span>
                                <div class="payment-value-with-copy">
                                    <span class="fw-bold payment-value-text" style="color: var(--text-primary);"
                                        id="display-network-name">{{ $walletTrc20['name'] }}</span>
                                    <button type="button" class="btn-copy-mini" onclick="copyNetworkName()"
                                        title="Copy">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat Setoran -->
                        <div class="payment-info-item">
                            <div class="payment-info-row">
                                <span class="text-muted small payment-label">Alamat Setoran</span>
                                <div class="payment-value-with-copy">
                                    <span class="fw-bold payment-value-text wallet-address"
                                        style="color: var(--text-primary);"
                                        id="display-wallet-address">{{ $walletTrc20['address'] }}</span>
                                    <button type="button" class="btn-copy-mini" onclick="copyWalletAddress()"
                                        title="Copy">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="alert-info-box mt-3">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <span class="small">Transfer USDT sesuai nominal yang tertera menggunakan network yang dipilih
                                (<span id="display-network-type">TRC20</span>). Lalu upload bukti transfer</span>
                        </div>
                    </div>

                    <!-- Upload Proof -->
                    <div class="seamless-upload-section">
                        <h6 class="mb-3 fw-bold" style="color: var(--text-primary); font-size: 14px;">Upload Proof of
                            Transfer</h6>
                        <div class="upload-area" onclick="document.getElementById('file-upload').click()">
                            <input type="file" name="payment_proof" id="file-upload" accept="image/*"
                                style="display: none;" onchange="handleFileUpload(event)" required>
                            <div id="upload-placeholder">
                                <i class="bi bi-cloud-upload upload-icon"></i>
                                <p class="mb-1" style="color: var(--text-primary);">Click to upload</p>
                                <small class="text-muted">PNG, JPG up to 5MB</small>
                            </div>
                            <div id="upload-preview" style="display: none;">
                                <img id="preview-image" src="" alt="Preview" class="preview-image">
                                <p class="mb-0 mt-2" style="color: var(--text-primary);" id="file-name"></p>
                            </div>
                        </div>
                        @error('payment_proof')
                            <small class="text-danger mt-1 d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="seamless-action-section">
                        <div class="row g-2">
                            <div class="col-6">
                                <button type="button" class="btn btn-outline-gold w-100" onclick="goToStep1()">
                                    <i class="bi bi-arrow-left me-2"></i>Back
                                </button>
                            </div>
                            <div class="col-6">
                                <button type="button" class="btn btn-gold w-100" onclick="submitDeposit()">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

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

            /* Seamless Step Wrapper */
            .seamless-step-wrapper {
                padding: 20px;
                background: transparent;
            }

            /* Seamless Balance Info */
            .seamless-balance-info {
                padding: 20px;
                background: rgba(169, 126, 0, 0.05);
                margin: 0;
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

            /* Wallet Type Selection */
            .wallet-type-selection {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            .wallet-type-option {
                position: relative;
                cursor: pointer;
            }

            .wallet-type-option input[type="radio"] {
                position: absolute;
                opacity: 0;
                pointer-events: none;
            }

            .wallet-type-label {
                display: block;
                padding: 16px;
                background: rgba(169, 126, 0, 0.05);
                border: 2px solid var(--border-color);
                border-radius: 12px;
                cursor: pointer;
                transition: all 0.2s ease;
                margin: 0;
            }

            .wallet-type-option input[type="radio"]:checked+.wallet-type-label {
                background: rgba(169, 126, 0, 0.1);
                border-color: var(--gold-color);
            }

            .wallet-type-label:hover {
                background: rgba(169, 126, 0, 0.08);
                border-color: rgba(169, 126, 0, 0.5);
            }

            .wallet-type-header {
                display: flex;
                align-items: center;
                color: var(--text-primary);
                margin-bottom: 4px;
            }

            .wallet-type-header i {
                font-size: 10px;
                color: var(--text-muted);
                transition: color 0.2s ease;
            }

            .wallet-type-option input[type="radio"]:checked+.wallet-type-label .wallet-type-header i {
                color: var(--gold-color);
            }

            .wallet-type-details {
                padding-left: 18px;
            }

            /* Seamless Action Section */
            .seamless-action-section {
                padding: 20px;
                background: transparent;
            }

            /* Seamless Summary Section */
            .seamless-summary-section {
                padding: 20px;
                background: rgba(169, 126, 0, 0.05);
            }

            /* Seamless Payment Section */
            .seamless-payment-section {
                padding: 20px;
                background: transparent;
            }

            /* Payment Info Responsive Layout */
            .payment-info-item {
                padding: 12px 0;
            }

            .payment-info-item:not(:last-child) {
                border-bottom: 1px solid var(--border-color);
            }

            .payment-info-row {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 15px;
                flex-wrap: wrap;
            }

            .payment-label {
                flex-shrink: 0;
                min-width: 100px;
            }

            .payment-value-with-copy {
                display: flex;
                align-items: center;
                gap: 8px;
                flex: 1;
                justify-content: flex-end;
            }

            .payment-value-text {
                font-size: 14px;
                line-height: 1.5;
                word-break: break-all;
                text-align: right;
            }

            .wallet-address {
                font-family: 'Courier New', Courier, monospace;
                font-size: 13px;
                letter-spacing: 0.5px;
            }

            /* Responsive adjustments */
            @media (max-width: 576px) {
                .payment-info-row {
                    flex-direction: column;
                    gap: 8px;
                    align-items: flex-start;
                }

                .payment-label {
                    min-width: auto;
                }

                .payment-value-with-copy {
                    width: 100%;
                    justify-content: space-between;
                }

                .payment-value-text {
                    text-align: left;
                    font-size: 12px;
                    flex: 1;
                    word-break: break-all;
                }

                .wallet-address {
                    font-size: 11px;
                }
            }

            /* Button copy styling */
            .btn-copy-mini {
                background: rgba(169, 126, 0, 0.15);
                border: 1px solid rgba(169, 126, 0, 0.3);
                border-radius: 6px;
                width: 32px;
                height: 32px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: all 0.2s ease;
                cursor: pointer;
                padding: 0;
                flex-shrink: 0;
            }

            .btn-copy-mini:hover {
                background: rgba(169, 126, 0, 0.25);
                border-color: rgba(169, 126, 0, 0.5);
            }

            .btn-copy-mini i {
                color: var(--gold-color);
                font-size: 14px;
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

            /* Seamless Upload Section */
            .seamless-upload-section {
                padding: 20px;
                background: transparent;
            }

            /* Tab Content */
            .step-content {
                display: none;
            }

            .step-content.active {
                display: block;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            let selectedFile = null;
            let selectedWalletType = 'trc20';

            // Wallet data from backend
            const walletData = {
                trc20: {
                    name: '{{ $walletTrc20['name'] }}',
                    address: '{{ $walletTrc20['address'] }}'
                },
                bep20: {
                    name: '{{ $walletBep20['name'] }}',
                    address: '{{ $walletBep20['address'] }}'
                }
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

            function setAmount(amount) {
                document.getElementById('deposit-amount').value = amount;
            }

            function selectWalletType(type) {
                selectedWalletType = type;
                document.getElementById('wallet-' + type).checked = true;
            }

            function goToStep2() {
                const amount = document.getElementById('deposit-amount').value;
                if (!amount || amount <= 0) {
                    alert('Please enter a valid amount');
                    return;
                }
                if (amount < 10) {
                    alert('Minimum deposit amount is 10 USDT');
                    return;
                }

                // Get selected wallet type
                const walletType = document.querySelector('input[name="wallet_type_display"]:checked').value;

                // Update form data
                document.getElementById('summary-amount').textContent = parseFloat(amount).toFixed(2) + ' USDT';
                document.getElementById('form-amount').value = amount;
                document.getElementById('form-wallet-type').value = walletType;

                // Update payment details based on selected wallet
                const wallet = walletData[walletType];
                document.getElementById('display-network-name').textContent = wallet.name;
                document.getElementById('display-wallet-address').textContent = wallet.address;
                document.getElementById('display-network-type').textContent = walletType.toUpperCase();

                // Switch steps
                document.getElementById('step-1').classList.remove('active');
                document.getElementById('step-2').classList.add('active');

                // Update indicators
                document.getElementById('step-1-indicator').classList.remove('active');
                document.getElementById('step-1-indicator').classList.add('completed');
                document.getElementById('step-2-indicator').classList.add('active');

                // Scroll to top
                document.querySelector('.scrollable-content').scrollTop = 0;
            }

            function goToStep1() {
                document.getElementById('step-2').classList.remove('active');
                document.getElementById('step-1').classList.add('active');

                document.getElementById('step-2-indicator').classList.remove('active');
                document.getElementById('step-1-indicator').classList.add('active');
                document.getElementById('step-1-indicator').classList.remove('completed');

                document.querySelector('.scrollable-content').scrollTop = 0;
            }

            function copyNetworkName() {
                const text = document.getElementById('display-network-name').textContent;
                copyText(text);
            }

            function copyWalletAddress() {
                const text = document.getElementById('display-wallet-address').textContent;
                copyText(text);
            }

            function copyText(text) {
                navigator.clipboard.writeText(text).then(() => {
                    alert('Copied: ' + text);
                });
            }

            function handleFileUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    // Validate file size (5MB)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size must not exceed 5MB');
                        event.target.value = '';
                        return;
                    }

                    // Validate file type
                    const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Only JPG, JPEG, and PNG files are allowed');
                        event.target.value = '';
                        return;
                    }

                    selectedFile = file;
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview-image').src = e.target.result;
                        document.getElementById('file-name').textContent = file.name;
                        document.getElementById('upload-placeholder').style.display = 'none';
                        document.getElementById('upload-preview').style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                }
            }

            function submitDeposit() {
                const amount = document.getElementById('deposit-amount').value;
                const fileInput = document.getElementById('file-upload');

                if (!fileInput.files || !fileInput.files[0]) {
                    alert('Please upload proof of transfer');
                    return;
                }

                // Confirm before submit
                if (confirm('Are you sure you want to submit this deposit request?')) {
                    document.getElementById('deposit-form').submit();
                }
            }
        </script>
    @endpush
@endsection
