@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">

            <!-- Flash Messages -->
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

            <!-- Card 1: Data Diri -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <h6 class="text-white mb-0">Data Diri</h6>
                </div>
                <div class="p-3">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="profile-avatar-large">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="text-white fw-bold mb-1" style="font-size: 16px;">{{ $user->name }}</div>
                            <div class="d-flex align-items-center gap-1">
                                <i class="bi bi-telephone-fill text-gold" style="font-size: 12px;"></i>
                                <small class="text-muted">{{ $user->phone }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Balance -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <p class="text-muted mb-1 small">Total Balance</p>
                        <h3 class="text-gold mb-0 fw-bold">{{ number_format($userBalance, 2) }} USDT</h3>
                    </div>
                    <div class="balance-icon-wrapper">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>

                <!-- Balance Breakdown -->
                @if (isset($balanceBreakdown))
                    <div class="mb-3"
                        style="padding: 12px; background: rgba(245, 166, 35, 0.05); border-radius: 8px; border: 1px solid var(--border-color);">

                        <!-- Income Section -->
                        <div class="mb-2 pb-2" style="border-bottom: 1px dashed rgba(255,255,255,0.1);">
                            <small class="text-muted d-block mb-2"
                                style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="bi bi-arrow-down-circle me-1"></i>Income
                            </small>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small" style="padding-left: 8px;">Deposits</span>
                                <span class="text-success small fw-bold">
                                    +{{ number_format($balanceBreakdown['total_deposits'], 2) }} USDT
                                </span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted small" style="padding-left: 8px;">Commissions</span>
                                <span class="text-success small fw-bold">
                                    +{{ number_format($balanceBreakdown['total_commissions'], 2) }} USDT
                                </span>
                            </div>
                        </div>

                        <!-- Expense Section -->
                        <div class="mb-0">
                            <small class="text-muted d-block mb-2"
                                style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="bi bi-arrow-up-circle me-1"></i>Expenses
                            </small>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small" style="padding-left: 8px;">Withdrawals (Net)</span>
                                <span class="text-danger small fw-bold">
                                    -{{ number_format($balanceBreakdown['total_withdrawals_net'], 2) }} USDT
                                </span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted small" style="padding-left: 8px;">Withdrawal Fees</span>
                                <span class="text-danger small fw-bold">
                                    -{{ number_format($balanceBreakdown['total_withdrawal_fees'], 2) }} USDT
                                </span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center pt-2"
                                style="border-top: 1px dashed rgba(255,255,255,0.1);">
                                <span class="text-muted small" style="padding-left: 8px;">
                                    <i class="bi bi-calculator me-1"></i>Total Withdrawn
                                </span>
                                <span class="text-white small fw-bold">
                                    {{ number_format($balanceBreakdown['total_withdrawals'], 2) }} USDT
                                </span>
                            </div>
                        </div>

                        <!-- Verification Note -->
                        <div class="mt-2 pt-2" style="border-top: 1px solid rgba(255,255,255,0.1);">
                            <small class="text-muted d-block" style="font-size: 11px;">
                                <i class="bi bi-info-circle me-1"></i>
                                Balance = Deposits + Commissions - Total Withdrawn
                                <br>
                                <span style="padding-left: 16px;">
                                    = {{ number_format($balanceBreakdown['total_deposits'], 2) }}
                                    + {{ number_format($balanceBreakdown['total_commissions'], 2) }}
                                    - {{ number_format($balanceBreakdown['total_withdrawals'], 2) }}
                                    = {{ number_format($userBalance, 2) }} USDT
                                </span>
                            </small>
                        </div>
                    </div>
                @endif

                <div class="row g-2">
                    <div class="col-6">
                        <a href="{{ route('member.deposit.index') }}" class="btn btn-gold w-100">
                            <i class="bi bi-plus-circle me-1"></i>Deposit
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="{{ route('member.withdraw.index') }}" class="btn btn-outline-gold w-100">
                            <i class="bi bi-arrow-up-circle me-1"></i>Withdraw
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 3: Transaction History (NEW) -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <h6 class="text-white mb-0">Transaction History</h6>
                </div>

                <!-- Transaction Tabs -->
                <div class="transaction-tabs">
                    <button class="transaction-tab active" onclick="switchTransactionTab('deposit')">
                        <i class="bi bi-arrow-down-circle me-1"></i>
                        Deposit
                        <span class="tab-count">{{ $deposits->count() }}</span>
                    </button>
                    <button class="transaction-tab" onclick="switchTransactionTab('withdrawal')">
                        <i class="bi bi-arrow-up-circle me-1"></i>
                        Withdrawal
                        <span class="tab-count">{{ $withdrawals->count() }}</span>
                    </button>
                    <button class="transaction-tab" onclick="switchTransactionTab('commission')">
                        <i class="bi bi-gift me-1"></i>
                        Commission
                        <span class="tab-count">{{ $commissions->count() }}</span>
                    </button>
                </div>

                <!-- Deposit List -->
                <div id="deposit-list" class="transaction-list active">
                    @forelse($deposits as $deposit)
                        <div class="transaction-item">
                            <div class="d-flex align-items-start gap-3">
                                <div class="transaction-icon-wrapper deposit">
                                    <i class="bi bi-arrow-down-circle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <div>
                                            <h6 class="text-white mb-0 fw-bold" style="font-size: 14px;">Deposit</h6>
                                            <p class="text-muted small mb-0" style="font-size: 11px;">
                                                {{ $deposit->reference }}</p>
                                        </div>
                                        <div class="text-end">
                                            <h6 class="text-success mb-0 fw-bold" style="font-size: 14px;">
                                                +{{ number_format($deposit->amount, 2) }} USDT
                                            </h6>
                                            <span class="status-badge-mini {{ $deposit->status }}">
                                                {{ ucfirst($deposit->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted" style="font-size: 11px;">
                                            <i
                                                class="bi bi-calendar3 me-1"></i>{{ $deposit->created_at->format('d M Y, H:i') }}
                                        </small>
                                        @if ($deposit->payment_method)
                                            <small class="text-gold" style="font-size: 11px;">
                                                <i
                                                    class="bi bi-credit-card me-1"></i>{{ ucfirst(str_replace('_', ' ', $deposit->payment_method)) }}
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-transaction-state">
                            <i class="bi bi-inbox"></i>
                            <p class="text-muted mb-0">No deposit history</p>
                        </div>
                    @endforelse

                    @if ($deposits->count() > 0)
                        <div class="p-3">
                            <a href="{{ route('member.deposit.history') }}" class="btn btn-outline-gold w-100 btn-sm">
                                View All Deposits
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Withdrawal List -->
                <div id="withdrawal-list" class="transaction-list">
                    @forelse($withdrawals as $withdrawal)
                        <div class="transaction-item">
                            <div class="d-flex align-items-start gap-3">
                                <div class="transaction-icon-wrapper withdrawal">
                                    <i class="bi bi-arrow-up-circle"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <div>
                                            <h6 class="text-white mb-0 fw-bold" style="font-size: 14px;">Withdrawal</h6>
                                            <p class="text-muted small mb-0" style="font-size: 11px;">
                                                {{ $withdrawal->reference }}</p>
                                        </div>
                                        <div class="text-end">
                                            <h6 class="text-gold mb-0 fw-bold" style="font-size: 14px;">
                                                -{{ number_format($withdrawal->amount, 2) }} USDT
                                            </h6>
                                            <span class="status-badge-mini {{ $withdrawal->status }}">
                                                {{ ucfirst($withdrawal->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column gap-1 mt-2">
                                        <div class="d-flex justify-content-between">
                                            <small class="text-muted" style="font-size: 11px;">Fee (2%)</small>
                                            <small class="text-muted"
                                                style="font-size: 11px;">{{ number_format($withdrawal->withdrawal_fee, 2) }}
                                                USDT</small>
                                        </div>
                                        <small class="text-muted" style="font-size: 11px;">
                                            <i
                                                class="bi bi-calendar3 me-1"></i>{{ $withdrawal->created_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-transaction-state">
                            <i class="bi bi-inbox"></i>
                            <p class="text-muted mb-0">No withdrawal history</p>
                        </div>
                    @endforelse

                    @if ($withdrawals->count() > 0)
                        <div class="p-3">
                            <a href="{{ route('member.withdraw.history') }}" class="btn btn-outline-gold w-100 btn-sm">
                                View All Withdrawals
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Commission List -->
                <div id="commission-list" class="transaction-list">
                    @forelse($commissions as $commission)
                        <div class="transaction-item">
                            <div class="d-flex align-items-start gap-3">
                                <div class="transaction-icon-wrapper commission">
                                    <i class="bi bi-gift"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <div>
                                            <h6 class="text-white mb-0 fw-bold" style="font-size: 14px;">Commission</h6>
                                            <p class="text-muted small mb-0" style="font-size: 11px;">
                                                {{ $commission->reference }}</p>
                                        </div>
                                        <div class="text-end">
                                            <h6 class="text-gold mb-0 fw-bold" style="font-size: 14px;">
                                                +{{ number_format($commission->amount, 2) }} USDT
                                            </h6>
                                            <span class="status-badge-mini {{ $commission->status }}">
                                                {{ ucfirst($commission->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <small class="text-muted" style="font-size: 11px;">
                                            <i
                                                class="bi bi-calendar3 me-1"></i>{{ $commission->created_at->format('d M Y, H:i') }}
                                        </small>
                                        @if ($commission->source_user_id)
                                            <small class="text-gold" style="font-size: 11px;">
                                                <i class="bi bi-person me-1"></i>From referral
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="empty-transaction-state">
                            <i class="bi bi-inbox"></i>
                            <p class="text-muted mb-0">No commission history</p>
                        </div>
                    @endforelse

                    @if ($commissions->count() > 0)
                        <div class="p-3">
                            <a href="#" class="btn btn-outline-gold w-100 btn-sm">
                                View All Commissions
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Card 4: Wallet List -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="text-white mb-0">Wallet List</h6>
                        <span class="badge-count">{{ $wallets->count() }}/3</span>
                    </div>
                </div>

                @forelse($wallets as $wallet)
                    <!-- Bank Item -->
                    <div class="bank-list-item">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-start gap-3 flex-grow-1">
                                <div class="bank-icon-circle">
                                    <i class="bi bi-wallet-fill"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="text-white fw-bold mb-1">{{ $wallet->account_name }}</div>
                                    <div class="text-muted small">{{ $wallet->account_number }}</div>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn-bank-action btn-bank-edit"
                                    onclick="openEditModal({{ $wallet->id }}, '{{ $wallet->account_name }}', '{{ $wallet->account_number }}')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <form action="{{ route('member.wallet.destroy', $wallet->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus wallet ini?')"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-bank-action btn-bank-delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-3 text-center">
                        <p class="text-muted mb-0">Belum ada wallet</p>
                    </div>
                @endforelse

                <!-- Add Bank Button -->
                <div class="p-3">
                    <button class="btn btn-outline-gold w-100" data-bs-toggle="modal" data-bs-target="#addWalletModal"
                        @if ($wallets->count() >= 3) disabled @endif>
                        <i class="bi bi-plus-circle me-2"></i>Tambah Bank
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Add Wallet -->
    <div class="modal fade" id="addWalletModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: var(--card-dark); border: 1px solid var(--border-color);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title text-white">Tambah Wallet</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('member.wallet.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-white">Nama Rekening</label>
                            <input type="text" name="account_name" class="form-control-dark"
                                placeholder="Masukkan nama pemilik rekening" required value="{{ old('account_name') }}">
                            @error('account_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">Nomor Rekening</label>
                            <input type="text" name="account_number" class="form-control-dark"
                                placeholder="Masukkan nomor rekening" required value="{{ old('account_number') }}">
                            @error('account_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                        <button type="button" class="btn btn-outline-gold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-gold">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Wallet -->
    <div class="modal fade" id="editWalletModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: var(--card-dark); border: 1px solid var(--border-color);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title text-white">Edit Wallet</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editWalletForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label text-white">Nama Rekening</label>
                            <input type="text" name="account_name" id="edit_account_name" class="form-control-dark"
                                placeholder="Masukkan nama pemilik rekening" required>
                            @error('account_name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-white">Nomor Rekening</label>
                            <input type="text" name="account_number" id="edit_account_number"
                                class="form-control-dark" placeholder="Masukkan nomor rekening" required>
                            @error('account_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid var(--border-color);">
                        <button type="button" class="btn btn-outline-gold" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-gold">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        /* Transaction Tabs */
        .transaction-tabs {
            display: flex;
            border-bottom: 1px solid var(--border-color);
            background: rgba(245, 166, 35, 0.03);
        }

        .transaction-tab {
            flex: 1;
            padding: 12px 8px;
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
        }

        .transaction-tab:hover {
            background: rgba(245, 166, 35, 0.05);
            color: var(--gold-color);
        }

        .transaction-tab.active {
            color: var(--gold-color);
            background: rgba(245, 166, 35, 0.1);
        }

        .transaction-tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gold-color);
        }

        .tab-count {
            background: rgba(245, 166, 35, 0.2);
            border: 1px solid rgba(245, 166, 35, 0.3);
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 700;
        }

        .transaction-tab.active .tab-count {
            background: var(--gold-color);
            border-color: var(--gold-color);
            color: #000;
        }

        /* Transaction List */
        .transaction-list {
            display: none;
        }

        .transaction-list.active {
            display: block;
        }

        /* Transaction Item */
        .transaction-item {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
        }

        .transaction-item:hover {
            background-color: rgba(245, 166, 35, 0.05);
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        /* Transaction Icon Wrapper */
        .transaction-icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            flex-shrink: 0;
        }

        .transaction-icon-wrapper i {
            font-size: 20px;
        }

        .transaction-icon-wrapper.deposit {
            background: rgba(40, 167, 69, 0.15);
            border-color: rgba(40, 167, 69, 0.3);
        }

        .transaction-icon-wrapper.deposit i {
            color: #28a745;
        }

        .transaction-icon-wrapper.withdrawal {
            background: rgba(245, 166, 35, 0.15);
            border-color: rgba(245, 166, 35, 0.3);
        }

        .transaction-icon-wrapper.withdrawal i {
            color: var(--gold-color);
        }

        .transaction-icon-wrapper.commission {
            background: rgba(138, 43, 226, 0.15);
            border-color: rgba(138, 43, 226, 0.3);
        }

        .transaction-icon-wrapper.commission i {
            color: #8a2be2;
        }

        /* Status Badge Mini */
        .status-badge-mini {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-badge-mini.pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .status-badge-mini.approved {
            background: rgba(59, 181, 232, 0.15);
            color: var(--blue-color);
            border: 1px solid rgba(59, 181, 232, 0.3);
        }

        .status-badge-mini.completed {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-badge-mini.rejected {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        /* Empty Transaction State */
        .empty-transaction-state {
            padding: 40px 20px;
            text-align: center;
        }

        .empty-transaction-state i {
            font-size: 48px;
            color: var(--text-muted);
            opacity: 0.4;
            margin-bottom: 12px;
            display: block;
        }

        .empty-transaction-state p {
            font-size: 13px;
        }

        /* Responsive */
        @media (max-width: 375px) {
            .transaction-tab {
                padding: 10px 6px;
                font-size: 11px;
            }

            .transaction-tab i {
                font-size: 12px;
            }

            .tab-count {
                font-size: 9px;
                padding: 1px 5px;
            }

            .transaction-icon-wrapper {
                width: 36px;
                height: 36px;
            }

            .transaction-icon-wrapper i {
                font-size: 18px;
            }
        }
    </style>

    <script>
        // Switch transaction tabs
        function switchTransactionTab(type) {
            // Update active tab
            document.querySelectorAll('.transaction-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.closest('.transaction-tab').classList.add('active');

            // Show corresponding list
            document.querySelectorAll('.transaction-list').forEach(list => {
                list.classList.remove('active');
            });
            document.getElementById(type + '-list').classList.add('active');
        }

        function openEditModal(id, accountName, accountNumber) {
            document.getElementById('editWalletForm').action = "{{ url('member/wallet') }}/" + id;
            document.getElementById('edit_account_name').value = accountName;
            document.getElementById('edit_account_number').value = accountNumber;

            var editModal = new bootstrap.Modal(document.getElementById('editWalletModal'));
            editModal.show();
        }

        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
@endsection
