@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('member.profile.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <h5 class="text-white mb-3">Deposit</h5>

            <!-- Step Indicator -->
            <div class="step-indicator mb-4">
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

            <!-- Step 1: Amount -->
            <div id="step-1" class="step-content active">
                <!-- Current Balance Info -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 small">Current Balance</p>
                            <h5 class="text-gold mb-0 fw-bold">$ 15,250.00</h5>
                        </div>
                        <div class="balance-icon-wrapper">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                </div>

                <!-- Amount Input Card -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white mb-3">Deposit Amount</h6>
                    <div class="mb-3">
                        <label class="text-muted small mb-2 d-block">Amount (USD)</label>
                        <div class="input-with-icon">
                            <span class="input-icon">$</span>
                            <input type="number" id="deposit-amount" class="form-control-dark with-icon"
                                placeholder="Enter amount" value="100">
                        </div>
                    </div>
                    <div class="amount-quick-select">
                        <button class="quick-amount-btn" onclick="setAmount(50)">$50</button>
                        <button class="quick-amount-btn" onclick="setAmount(100)">$100</button>
                        <button class="quick-amount-btn" onclick="setAmount(250)">$250</button>
                        <button class="quick-amount-btn" onclick="setAmount(500)">$500</button>
                    </div>
                </div>

                <!-- Continue Button -->
                <button class="btn btn-gold w-100" onclick="goToStep2()">
                    Continue <i class="bi bi-arrow-right ms-2"></i>
                </button>
            </div>

            <!-- Step 2: Payment Method -->
            <div id="step-2" class="step-content">
                <!-- Amount Summary -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <p class="text-muted mb-0">Deposit Amount</p>
                        <h5 class="text-gold mb-0 fw-bold" id="summary-amount">$ 100.00</h5>
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white mb-3">Choose Payment Method</h6>

                    <!-- E-Wallet Option -->
                    <div class="payment-method-option" onclick="selectMethod('ewallet')">
                        <input type="radio" name="payment-method" id="method-ewallet" class="payment-radio" checked>
                        <label for="method-ewallet" class="payment-label">
                            <div class="d-flex align-items-center gap-3">
                                <div class="payment-icon ewallet">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <div>
                                    <div class="text-white fw-bold mb-1" style="font-size: 14px;">E-Wallet (OVO)</div>
                                    <small class="text-muted">Transfer to OVO number</small>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- QR Code Option -->
                    <div class="payment-method-option" onclick="selectMethod('qrcode')">
                        <input type="radio" name="payment-method" id="method-qrcode" class="payment-radio">
                        <label for="method-qrcode" class="payment-label">
                            <div class="d-flex align-items-center gap-3">
                                <div class="payment-icon qrcode">
                                    <i class="bi bi-qr-code"></i>
                                </div>
                                <div>
                                    <div class="text-white fw-bold mb-1" style="font-size: 14px;">QR Code</div>
                                    <small class="text-muted">Scan QR to pay</small>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Payment Details: E-Wallet -->
                <div id="payment-details-ewallet" class="payment-details active">
                    <div class="card-dark shadow-sm p-3 mb-3">
                        <h6 class="text-white mb-3">Payment Details</h6>
                        <div class="payment-info-item">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted small">OVO Number</span>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-white fw-bold">0812-3456-7890</span>
                                    <button class="btn-copy-mini" onclick="copyText('0812-3456-7890')" title="Copy">
                                        <i class="bi bi-clipboard"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="payment-info-item">
                            <div class="d-flex align-items-center justify-content-between">
                                <span class="text-muted small">Account Name</span>
                                <span class="text-white fw-bold">Jhonson Investment</span>
                            </div>
                        </div>
                        <div class="alert-info-box mt-3">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <span class="small">Transfer sesuai nominal yang tertera dan upload bukti transfer</span>
                        </div>
                    </div>
                </div>

                <!-- Payment Details: QR Code -->
                <div id="payment-details-qrcode" class="payment-details">
                    <div class="card-dark shadow-sm p-3 mb-3">
                        <h6 class="text-white mb-3 text-center">Scan QR Code</h6>
                        <div class="qr-code-container">
                            <img src="https://via.placeholder.com/200x200/2d3158/f5a623?text=QR+CODE" alt="QR Code"
                                class="qr-code-image">
                        </div>
                        <div class="alert-info-box mt-3">
                            <i class="bi bi-info-circle-fill me-2"></i>
                            <span class="small">Scan QR code dengan aplikasi e-wallet Anda dan upload bukti
                                transfer</span>
                        </div>
                    </div>
                </div>

                <!-- Upload Proof -->
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white mb-3">Upload Proof of Transfer</h6>
                    <div class="upload-area" onclick="document.getElementById('file-upload').click()">
                        <input type="file" id="file-upload" accept="image/*" style="display: none;"
                            onchange="handleFileUpload(event)">
                        <div id="upload-placeholder">
                            <i class="bi bi-cloud-upload upload-icon"></i>
                            <p class="text-white mb-1">Click to upload</p>
                            <small class="text-muted">PNG, JPG up to 5MB</small>
                        </div>
                        <div id="upload-preview" style="display: none;">
                            <img id="preview-image" src="" alt="Preview" class="preview-image">
                            <p class="text-white mb-0 mt-2" id="file-name"></p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <button class="btn btn-outline-gold w-100" onclick="goToStep1()">
                            <i class="bi bi-arrow-left me-2"></i>Back
                        </button>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-gold w-100" onclick="submitDeposit()">
                            Submit
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        let selectedFile = null;

        function setAmount(amount) {
            document.getElementById('deposit-amount').value = amount;
        }

        function goToStep2() {
            const amount = document.getElementById('deposit-amount').value;
            if (!amount || amount <= 0) {
                alert('Please enter a valid amount');
                return;
            }

            // Update summary
            document.getElementById('summary-amount').textContent = '$ ' + parseFloat(amount).toFixed(2);

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

        function selectMethod(method) {
            if (method === 'ewallet') {
                document.getElementById('method-ewallet').checked = true;
                document.getElementById('payment-details-ewallet').classList.add('active');
                document.getElementById('payment-details-qrcode').classList.remove('active');
            } else {
                document.getElementById('method-qrcode').checked = true;
                document.getElementById('payment-details-qrcode').classList.add('active');
                document.getElementById('payment-details-ewallet').classList.remove('active');
            }
        }

        function copyText(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Copied: ' + text);
            });
        }

        function handleFileUpload(event) {
            const file = event.target.files[0];
            if (file) {
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
            const method = document.querySelector('input[name="payment-method"]:checked').id;

            if (!selectedFile) {
                alert('Please upload proof of transfer');
                return;
            }

            alert('Deposit request submitted!\nAmount: $' + amount + '\nMethod: ' + (method === 'method-ewallet' ?
                'E-Wallet' : 'QR Code'));
            // Here you would normally send the data to the server
        }
    </script>
@endsection
