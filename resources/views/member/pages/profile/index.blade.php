@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            {{-- <h5 class="text-white mb-3">Profile</h5> --}}

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
                        <h3 class="text-gold mb-0 fw-bold">$ 15,250.00</h3>
                    </div>
                    <div class="balance-icon-wrapper">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>

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

            <!-- Card 3: Bank Account List -->
            <div class="card-dark shadow-sm p-0 mb-3">
                <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
                    <div class="d-flex align-items-center justify-content-between">
                        <h6 class="text-white mb-0">Bank Account</h6>
                        <span class="badge-count">2/3</span>
                    </div>
                </div>

                <!-- Bank Item 1 -->
                <div class="bank-list-item">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="d-flex align-items-start gap-3 flex-grow-1">
                            <div class="bank-icon-circle">
                                <i class="bi bi-bank2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="text-white fw-bold mb-1" style="font-size: 14px;">Bank Central Asia</div>
                                <div class="text-muted small mb-1">1234567890</div>
                                <div class="text-muted small">John Doe</div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn-bank-action btn-bank-edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn-bank-action btn-bank-delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Bank Item 2 -->
                <div class="bank-list-item">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="d-flex align-items-start gap-3 flex-grow-1">
                            <div class="bank-icon-circle">
                                <i class="bi bi-bank2"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="text-white fw-bold mb-1" style="font-size: 14px;">Bank Mandiri</div>
                                <div class="text-muted small mb-1">9876543210</div>
                                <div class="text-muted small">John Doe</div>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button class="btn-bank-action btn-bank-edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn-bank-action btn-bank-delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Add Bank Button -->
                <div class="p-3">
                    <button class="btn btn-outline-gold w-100">
                        <i class="bi bi-plus-circle me-2"></i>Tambah Bank
                    </button>
                </div>
            </div>

        </div>
    </div>
@endsection
