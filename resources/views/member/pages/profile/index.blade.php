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

                <!-- Balance Breakdown (Optional) -->
                @if (isset($balanceBreakdown))
                    <div class="mb-3"
                        style="padding: 12px; background: rgba(245, 166, 35, 0.05); border-radius: 8px; border: 1px solid var(--border-color);">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Total Deposits</span>
                            <span
                                class="text-white small fw-bold">{{ number_format($balanceBreakdown['total_deposits'], 2) }}
                                USDT</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Total Commissions</span>
                            <span
                                class="text-white small fw-bold">{{ number_format($balanceBreakdown['total_commissions'], 2) }}
                                USDT</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">Total Withdrawals</span>
                            <span
                                class="text-white small fw-bold">{{ number_format($balanceBreakdown['total_withdrawals'], 2) }}
                                USDT</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted small">Withdrawal Fees</span>
                            <span
                                class="text-white small fw-bold">{{ number_format($balanceBreakdown['total_withdrawal_fees'], 2) }}
                                USDT</span>
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

            <!-- Card 3: Wallet List -->
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
                                    onsubmit="return confirm('Yakin ingin menghapus wallet ini?')" style="display: inline;">
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

    <script>
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
