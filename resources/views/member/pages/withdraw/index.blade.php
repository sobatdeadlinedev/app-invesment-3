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

            <h5 class="text-white mb-3">Withdraw</h5>

            <!-- Current Balance Info -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Available Balance</p>
                        <h5 class="text-gold mb-0 fw-bold">$ 15,250.00</h5>
                    </div>
                    <div class="balance-icon-wrapper">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
            </div>

            <!-- Withdrawal Amount Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <h6 class="text-white mb-3">Withdrawal Amount</h6>
                <div class="mb-3">
                    <label class="text-muted small mb-2 d-block">Amount (USD)</label>
                    <div class="input-with-icon">
                        <span class="input-icon">$</span>
                        <input type="number" id="withdraw-amount" class="form-control-dark with-icon"
                            placeholder="Enter amount" value="">
                    </div>
                </div>
                <div class="amount-quick-select">
                    <button class="quick-amount-btn" onclick="setWithdrawAmount(100)">$100</button>
                    <button class="quick-amount-btn" onclick="setWithdrawAmount(500)">$500</button>
                    <button class="quick-amount-btn" onclick="setWithdrawAmount(1000)">$1,000</button>
                    <button class="quick-amount-btn" onclick="setWithdrawAmount(5000)">$5,000</button>
                </div>
            </div>

            <!-- Select Bank Account Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <h6 class="text-white mb-3">Select Bank Account</h6>
                <div>
                    <label class="text-muted small mb-2 d-block">Choose your bank account</label>
                    <select id="bank-account" class="form-control-dark">
                        <option value="">-- Select Bank Account --</option>
                        <option value="1">Bank Central Asia - 1234567890 (John Doe)</option>
                        <option value="2">Bank Mandiri - 9876543210 (John Doe)</option>
                    </select>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-info-circle-fill text-gold" style="font-size: 18px; margin-top: 2px;"></i>
                    <div>
                        <h6 class="text-white mb-1" style="font-size: 13px;">Withdrawal Information</h6>
                        <p class="small text-muted mb-0" style="font-size: 12px;">
                            Withdrawal akan diproses dalam 1-3 hari kerja. Pastikan data bank Anda sudah benar.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button class="btn btn-gold w-100" onclick="submitWithdraw()">
                Submit Withdrawal
            </button>

        </div>
    </div>

    <script>
        function setWithdrawAmount(amount) {
            document.getElementById('withdraw-amount').value = amount;
        }

        function submitWithdraw() {
            const amount = document.getElementById('withdraw-amount').value;
            const bankSelect = document.getElementById('bank-account');
            const selectedBank = bankSelect.options[bankSelect.selectedIndex].text;

            if (!amount || amount <= 0) {
                alert('Please enter a valid amount');
                return;
            }

            if (!bankSelect.value) {
                alert('Please select a bank account');
                return;
            }
        }
    </script>
@endsection
