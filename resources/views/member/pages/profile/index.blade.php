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

            <!-- Section 1: Data Diri -->
            <div class="seamless-section mb-4">
                <div class="section-header">
                    <h6 class="section-title">Data Diri</h6>
                    <a href="{{ route('member.verification.index') }}" class="btn-verification-link">
                        <span>Verifikasi Akun</span>
                    </a>
                </div>
                <div class="section-content">
                    <div class="d-flex align-items-center gap-3">
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

            <!-- Section 2: Balance -->
            <div class="seamless-section mb-4">
                <div class="section-content">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div>
                            <p class="text-muted mb-1 small">Total Balance</p>
                            <h3 class="text-gold mb-0 fw-bold">{{ number_format($balanceBreakdown['total_balance'], 2) }}
                                USDT</h3>
                            <small class="text-muted">Exchange + Trade Balance</small>
                        </div>
                        <div class="balance-icon-wrapper">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>

                    <!-- Today's PnL -->
                    <div class="info-box pnl-box mb-3"
                        style="background: {{ $todayPnl >= 0 ? 'rgba(40, 167, 69, 0.05)' : 'rgba(220, 53, 69, 0.05)' }};">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block mb-1"
                                    style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="bi bi-graph-up-arrow me-1"></i>Today's PnL
                                </small>
                                <h4 class="mb-0 fw-bold {{ $todayPnl >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $todayPnl >= 0 ? '+' : '' }}{{ number_format($todayPnl, 2) }} USDT
                                </h4>
                                <small class="text-muted" style="font-size: 11px;">
                                    {{ now()->format('d M Y') }} •
                                    {{ $todayStats['total_trades'] }}
                                    trade{{ $todayStats['total_trades'] != 1 ? 's' : '' }}
                                    @if ($todayStats['total_trades'] > 0)
                                        • {{ number_format($todayStats['win_rate'], 1) }}% win rate
                                    @endif
                                </small>
                            </div>
                            <div class="pnl-icon-wrapper {{ $todayPnl >= 0 ? 'positive' : 'negative' }}">
                                <i
                                    class="bi bi-{{ $todayPnl >= 0 ? 'arrow-up-circle-fill' : 'arrow-down-circle-fill' }}"></i>
                            </div>
                        </div>

                        @if ($todayStats['total_trades'] > 0)
                            <div class="mt-3 pt-3" style="border-top: 1px dashed rgba(255,255,255,0.1);">
                                <div class="row g-2">
                                    <div class="col-4 text-center">
                                        <small class="text-muted d-block" style="font-size: 10px;">TOTAL BET</small>
                                        <span class="text-white fw-bold" style="font-size: 12px;">
                                            {{ number_format($todayStats['total_bet_amount'], 0) }}
                                        </span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <small class="text-muted d-block" style="font-size: 10px;">WIN/LOSS</small>
                                        <span class="text-white fw-bold" style="font-size: 12px;">
                                            {{ $todayStats['win_count'] }}/{{ $todayStats['loss_count'] }}
                                        </span>
                                    </div>
                                    <div class="col-4 text-center">
                                        <small class="text-muted d-block" style="font-size: 10px;">FEES</small>
                                        <span class="text-warning fw-bold" style="font-size: 12px;">
                                            {{ number_format($todayStats['total_fees'], 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Current Balance Breakdown -->
                    <div class="info-box mb-3">
                        <small class="text-muted d-block mb-2"
                            style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                            <i class="bi bi-wallet me-1"></i>Current Balance
                        </small>

                        <div class="balance-row">
                            <span class="text-muted small">Exchange Balance</span>
                            <span class="text-white small fw-bold">
                                {{ number_format($balanceBreakdown['exchange_balance'], 2) }} USDT
                            </span>
                        </div>

                        <div class="balance-row">
                            <span class="text-muted small">Trade Balance</span>
                            <span class="text-white small fw-bold">
                                {{ number_format($balanceBreakdown['trade_balance'], 2) }} USDT
                            </span>
                        </div>

                        @if ($balanceBreakdown['locked_balance'] > 0)
                            <div class="balance-row">
                                <span class="text-muted small" style="padding-left: 8px;">└ Locked (Trading)</span>
                                <span class="text-warning small fw-bold">
                                    -{{ number_format($balanceBreakdown['locked_balance'], 2) }} USDT
                                </span>
                            </div>
                            <div class="balance-row">
                                <span class="text-muted small" style="padding-left: 8px;">└ Available</span>
                                <span class="text-success small fw-bold">
                                    {{ number_format($balanceBreakdown['available_trade_balance'], 2) }} USDT
                                </span>
                            </div>
                        @endif
                    </div>

                    <!-- Transaction History Summary -->
                    @if (isset($balanceBreakdown))
                        <div class="info-box mb-3">
                            <!-- Income Section -->
                            <div class="mb-2 pb-2" style="border-bottom: 1px dashed rgba(255,255,255,0.1);">
                                <small class="text-muted d-block mb-2"
                                    style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="bi bi-arrow-down-circle me-1"></i>Total Income
                                </small>
                                <div class="balance-row">
                                    <span class="text-muted small">Deposits</span>
                                    <span class="text-success small fw-bold">
                                        +{{ number_format($balanceBreakdown['total_deposits'], 2) }} USDT
                                    </span>
                                </div>
                                <div class="balance-row">
                                    <span class="text-muted small">Commissions</span>
                                    <span class="text-success small fw-bold">
                                        +{{ number_format($balanceBreakdown['total_commissions'], 2) }} USDT
                                    </span>
                                </div>
                            </div>

                            <!-- Expense Section -->
                            <div class="mb-0">
                                <small class="text-muted d-block mb-2"
                                    style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    <i class="bi bi-arrow-up-circle me-1"></i>Total Expenses
                                </small>
                                <div class="balance-row">
                                    <span class="text-muted small">Withdrawals (Net)</span>
                                    <span class="text-danger small fw-bold">
                                        -{{ number_format($balanceBreakdown['total_withdrawals_net'], 2) }} USDT
                                    </span>
                                </div>
                                <div class="balance-row">
                                    <span class="text-muted small">Withdrawal Fees</span>
                                    <span class="text-danger small fw-bold">
                                        -{{ number_format($balanceBreakdown['total_withdrawal_fees'], 2) }} USDT
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Trading Volume Progress -->
                    @if ($balanceBreakdown['target_volume'] > 0)
                        <div class="info-box mb-3">
                            <small class="text-muted d-block mb-2"
                                style="font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">
                                <i class="bi bi-graph-up me-1"></i>Trading Volume
                            </small>
                            <div class="balance-row">
                                <span class="text-muted small">Target</span>
                                <span
                                    class="text-white small fw-bold">{{ number_format($balanceBreakdown['target_volume'], 2) }}
                                    USDT</span>
                            </div>
                            <div class="balance-row">
                                <span class="text-muted small">Achieved</span>
                                <span
                                    class="text-success small fw-bold">{{ number_format($balanceBreakdown['achieved_volume'], 2) }}
                                    USDT</span>
                            </div>
                            <div class="balance-row mb-3">
                                <span class="text-muted small">Remaining</span>
                                <span
                                    class="text-warning small fw-bold">{{ number_format($balanceBreakdown['remaining_volume'], 2) }}
                                    USDT</span>
                            </div>
                            <div class="progress" style="height: 6px; background-color: rgba(255,255,255,0.1);">
                                <div class="progress-bar" role="progressbar"
                                    style="width: {{ $balanceBreakdown['target_volume'] > 0 ? ($balanceBreakdown['achieved_volume'] / $balanceBreakdown['target_volume']) * 100 : 0 }}%; background: linear-gradient(90deg, #8a2be2, #da70d6);">
                                </div>
                            </div>
                            <small class="text-muted d-block text-center mt-2" style="font-size: 10px;">
                                {{ number_format($balanceBreakdown['target_volume'] > 0 ? ($balanceBreakdown['achieved_volume'] / $balanceBreakdown['target_volume']) * 100 : 0, 1) }}%
                                Completed
                            </small>
                        </div>
                    @endif

                    <div class="row g-2 mb-2">
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

                    <a href="{{ route('member.balance.transfer') }}" class="btn btn-outline-light w-100 btn-sm">
                        <i class="bi bi-arrow-left-right me-1"></i>Transfer Balance
                    </a>
                </div>
            </div>

            <!-- Section 3: Transaction History -->
            <div class="seamless-section mb-4">
                <div class="section-header mb-0">
                    <h6 class="section-title">Transaction History</h6>
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
                        <div class="section-footer">
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
                                            <small class="text-muted" style="font-size: 11px;">Fee (5%)</small>
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
                        <div class="section-footer">
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
                        <div class="section-footer">
                            <a href="#" class="btn btn-outline-gold w-100 btn-sm">
                                View All Commissions
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Section 4: Wallet List -->
            <div class="seamless-section mb-4">
                <div class="section-header">
                    <h6 class="section-title">Wallet List</h6>
                    <span class="badge-count">{{ $wallets->count() }}/3</span>
                </div>

                <!-- Currency Info -->
                <div class="currency-info-banner">
                    <div class="d-flex align-items-center gap-2">
                        <div class="currency-icon">
                            <span>₮</span>
                        </div>
                        <div>
                            <p class="text-muted mb-0 small" style="font-size: 11px;">Currency</p>
                            <h6 class="text-white mb-0 fw-bold" style="font-size: 13px;">USDT (Tether)</h6>
                        </div>
                    </div>
                </div>

                @forelse($wallets as $wallet)
                    <div class="wallet-item">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-start gap-3 flex-grow-1">
                                <div class="bank-icon-circle {{ $wallet->type }}">
                                    <i class="bi bi-wallet-fill"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <span class="wallet-type-badge {{ $wallet->type }}">
                                            {{ strtoupper($wallet->type) }}
                                        </span>
                                    </div>
                                    <div class="text-white fw-bold mb-1" style="font-size: 13px;">
                                        {{ $wallet->account_number }}
                                    </div>
                                    <small class="text-gold" style="font-size: 11px;">
                                        <i class="bi bi-info-circle me-1"></i>{{ $wallet->getTypeLabel() }}
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex gap-2">
                                <button class="btn-bank-action btn-bank-edit"
                                    onclick="openEditModal({{ $wallet->id }}, '{{ $wallet->type }}', '{{ $wallet->account_number }}')">
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
                    <div class="empty-state">
                        <i class="bi bi-wallet2"></i>
                        <p class="text-muted mb-0">Belum ada wallet</p>
                    </div>
                @endforelse

                <!-- Add Wallet Button -->
                <div class="section-footer">
                    <button class="btn btn-outline-gold w-100" data-bs-toggle="modal" data-bs-target="#addWalletModal"
                        @if ($wallets->count() >= 3) disabled @endif>
                        <i class="bi bi-plus-circle me-2"></i>Tambah Wallet
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- Modal Add Wallet -->
    <div class="modal fade" id="addWalletModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="background-color: var(--card-light); border: 1px solid var(--border-color);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title text-white">Tambah Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('member.wallet.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <!-- Currency Info in Modal -->
                        <div class="mb-3 p-3"
                            style="background: rgba(245, 166, 35, 0.05); border-radius: 8px; border: 1px solid var(--border-color);">
                            <div class="d-flex align-items-center gap-2">
                                <div
                                    style="width: 36px; height: 36px; background: rgba(245, 166, 35, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <span style="color: var(--gold-color); font-size: 18px; font-weight: bold;">₮</span>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small" style="font-size: 11px;">Currency</p>
                                    <h6 class="text-white mb-0 fw-bold" style="font-size: 13px;">USDT (Tether)</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Type Selection -->
                        <div class="mb-3">
                            <label class="form-label text-white">Network Type</label>
                            <div class="network-type-selector">
                                <label class="network-type-option">
                                    <input type="radio" name="type" value="trc20" checked>
                                    <div class="network-type-card">
                                        <div class="network-icon trc20">
                                            <i class="bi bi-circle-fill"></i>
                                        </div>
                                        <div class="network-info">
                                            <div class="network-name">TRC20</div>
                                            <small class="network-desc">TRON Network</small>
                                        </div>
                                        <div class="network-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                    </div>
                                </label>
                                <label class="network-type-option">
                                    <input type="radio" name="type" value="bep20">
                                    <div class="network-type-card">
                                        <div class="network-icon bep20">
                                            <i class="bi bi-circle-fill"></i>
                                        </div>
                                        <div class="network-info">
                                            <div class="network-name">BEP20</div>
                                            <small class="network-desc">Binance Smart Chain</small>
                                        </div>
                                        <div class="network-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Wallet Address -->
                        <div class="mb-3">
                            <label class="form-label text-white">Wallet Address</label>
                            <input type="text" name="account_number" class="form-control-dark"
                                placeholder="Masukkan wallet address" required value="{{ old('account_number') }}">
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">
                                <i class="bi bi-info-circle me-1"></i>Pastikan address sesuai dengan network yang dipilih
                            </small>
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
            <div class="modal-content"
                style="background-color: var(--card-light); border: 1px solid var(--border-color);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title text-white">Edit Wallet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editWalletForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <!-- Currency Info in Modal -->
                        <div class="mb-3 p-3"
                            style="background: rgba(245, 166, 35, 0.05); border-radius: 8px; border: 1px solid var(--border-color);">
                            <div class="d-flex align-items-center gap-2">
                                <div
                                    style="width: 36px; height: 36px; background: rgba(245, 166, 35, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                    <span style="color: var(--gold-color); font-size: 18px; font-weight: bold;">₮</span>
                                </div>
                                <div>
                                    <p class="text-muted mb-0 small" style="font-size: 11px;">Currency</p>
                                    <h6 class="text-white mb-0 fw-bold" style="font-size: 13px;">USDT (Tether)</h6>
                                </div>
                            </div>
                        </div>

                        <!-- Type Selection -->
                        <div class="mb-3">
                            <label class="form-label text-white">Network Type</label>
                            <div class="network-type-selector">
                                <label class="network-type-option">
                                    <input type="radio" name="type" value="trc20" id="edit_type_trc20">
                                    <div class="network-type-card">
                                        <div class="network-icon trc20">
                                            <i class="bi bi-circle-fill"></i>
                                        </div>
                                        <div class="network-info">
                                            <div class="network-name">TRC20</div>
                                            <small class="network-desc">TRON Network</small>
                                        </div>
                                        <div class="network-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                    </div>
                                </label>
                                <label class="network-type-option">
                                    <input type="radio" name="type" value="bep20" id="edit_type_bep20">
                                    <div class="network-type-card">
                                        <div class="network-icon bep20">
                                            <i class="bi bi-circle-fill"></i>
                                        </div>
                                        <div class="network-info">
                                            <div class="network-name">BEP20</div>
                                            <small class="network-desc">Binance Smart Chain</small>
                                        </div>
                                        <div class="network-check">
                                            <i class="bi bi-check-circle-fill"></i>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('type')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Wallet Address -->
                        <div class="mb-3">
                            <label class="form-label text-white">Wallet Address</label>
                            <input type="text" name="account_number" id="edit_account_number"
                                class="form-control-dark" placeholder="Masukkan wallet address" required>
                            <small class="text-muted d-block mt-1" style="font-size: 11px;">
                                <i class="bi bi-info-circle me-1"></i>Pastikan address sesuai dengan network yang dipilih
                            </small>
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
        /* Seamless Section Styles */
        .seamless-section {
            background: transparent;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            margin-bottom: 12px;
        }

        .section-title {
            color: var(--text-primary);
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }

        .section-content {
            background: rgba(255, 255, 255, 0.4);
            border-radius: 16px;
            padding: 16px;
            backdrop-filter: blur(10px);
        }

        .section-footer {
            padding: 16px;
            background: rgba(255, 255, 255, 0.4);
            border-radius: 0 0 16px 16px;
            margin-top: -12px;
        }

        /* Info Box */
        .info-box {
            padding: 12px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            border: 1px solid rgba(169, 126, 0, 0.1);
        }

        /* Balance Row */
        .balance-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
        }

        .balance-row:not(:last-child) {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* PnL Icon Wrapper */
        .pnl-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .pnl-icon-wrapper i {
            font-size: 28px;
        }

        .pnl-icon-wrapper.positive {
            background: rgba(40, 167, 69, 0.15);
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .pnl-icon-wrapper.positive i {
            color: #28a745;
        }

        .pnl-icon-wrapper.negative {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .pnl-icon-wrapper.negative i {
            color: #dc3545;
        }

        /* Currency Info Banner */
        .currency-info-banner {
            padding: 12px 16px;
            background: rgba(245, 166, 35, 0.08);
            border-radius: 12px;
            margin-bottom: 8px;
        }

        .currency-icon {
            width: 36px;
            height: 36px;
            background: rgba(245, 166, 35, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .currency-icon span {
            color: var(--gold-color);
            font-size: 18px;
            font-weight: bold;
        }

        /* Wallet Item */
        .wallet-item {
            padding: 14px 16px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            margin-bottom: 8px;
            transition: all 0.2s ease;
        }

        .wallet-item:hover {
            background: rgba(169, 126, 0, 0.08);
            transform: translateX(4px);
        }

        /* Empty State */
        .empty-state {
            padding: 32px 20px;
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            margin-bottom: 8px;
        }

        .empty-state i {
            font-size: 42px;
            color: var(--text-muted);
            opacity: 0.3;
            margin-bottom: 10px;
            display: block;
        }

        /* Transaction Tabs */
        .transaction-tabs {
            display: flex;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 12px 12px 0 0;
            overflow: hidden;
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
            background: rgba(169, 126, 0, 0.1);
            color: var(--gold-color);
        }

        .transaction-tab.active {
            color: var(--gold-color);
            background: rgba(169, 126, 0, 0.15);
        }

        .transaction-tab.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--gold-color);
            border-radius: 3px 3px 0 0;
        }

        .tab-count {
            background: rgba(169, 126, 0, 0.2);
            border: 1px solid rgba(169, 126, 0, 0.3);
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 700;
        }

        .transaction-tab.active .tab-count {
            background: var(--gold-color);
            border-color: var(--gold-color);
            color: #fff;
        }

        /* Transaction List */
        .transaction-list {
            display: none;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 0 0 12px 12px;
        }

        .transaction-list.active {
            display: block;
        }

        /* Transaction Item */
        .transaction-item {
            padding: 14px 16px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: background-color 0.2s ease;
        }

        .transaction-item:hover {
            background-color: rgba(169, 126, 0, 0.08);
        }

        .transaction-item:last-child {
            border-bottom: none;
        }

        /* Transaction Icon Wrapper */
        .transaction-icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 10px;
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
            color: #3bb5e8;
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
            opacity: 0.3;
            margin-bottom: 12px;
            display: block;
        }

        .empty-transaction-state p {
            font-size: 13px;
        }

        /* Wallet Type Badge */
        .wallet-type-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .wallet-type-badge.trc20 {
            background: rgba(255, 0, 0, 0.15);
            color: #ff4444;
            border: 1px solid rgba(255, 0, 0, 0.3);
        }

        .wallet-type-badge.bep20 {
            background: rgba(243, 186, 47, 0.15);
            color: #f3ba2f;
            border: 1px solid rgba(243, 186, 47, 0.3);
        }

        /* Bank Icon with Color Type */
        .bank-icon-circle.trc20 {
            background: rgba(255, 0, 0, 0.1);
            border-color: rgba(255, 0, 0, 0.3);
        }

        .bank-icon-circle.trc20 i {
            color: #ff4444;
        }

        .bank-icon-circle.bep20 {
            background: rgba(243, 186, 47, 0.1);
            border-color: rgba(243, 186, 47, 0.3);
        }

        .bank-icon-circle.bep20 i {
            color: #f3ba2f;
        }

        /* Network Type Selector */
        .network-type-selector {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .network-type-option {
            cursor: pointer;
            margin: 0;
        }

        .network-type-option input[type="radio"] {
            display: none;
        }

        .network-type-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            background: rgba(255, 255, 255, 0.03);
            border: 2px solid var(--border-color);
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .network-type-option:hover .network-type-card {
            background: rgba(169, 126, 0, 0.05);
            border-color: rgba(169, 126, 0, 0.3);
        }

        .network-type-option input[type="radio"]:checked~.network-type-card {
            background: rgba(169, 126, 0, 0.1);
            border-color: var(--gold-color);
        }

        .network-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .network-icon i {
            font-size: 20px;
        }

        .network-icon.trc20 {
            background: rgba(255, 0, 0, 0.15);
            border: 1px solid rgba(255, 0, 0, 0.3);
        }

        .network-icon.trc20 i {
            color: #ff4444;
        }

        .network-icon.bep20 {
            background: rgba(243, 186, 47, 0.15);
            border: 1px solid rgba(243, 186, 47, 0.3);
        }

        .network-icon.bep20 i {
            color: #f3ba2f;
        }

        .network-info {
            flex-grow: 1;
        }

        .network-name {
            color: var(--text-white);
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 2px;
        }

        .network-desc {
            color: var(--text-muted);
            font-size: 11px;
        }

        .network-check {
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .network-check i {
            font-size: 20px;
            color: var(--gold-color);
        }

        .network-type-option input[type="radio"]:checked~.network-type-card .network-check {
            opacity: 1;
        }

        /* Responsive */
        @media (max-width: 375px) {
            .section-content {
                padding: 14px;
            }

            .section-footer {
                padding: 14px;
            }

            .transaction-tab {
                padding: 10px 6px;
                font-size: 11px;
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
            document.querySelectorAll('.transaction-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.closest('.transaction-tab').classList.add('active');

            document.querySelectorAll('.transaction-list').forEach(list => {
                list.classList.remove('active');
            });
            document.getElementById(type + '-list').classList.add('active');
        }

        function openEditModal(id, type, accountNumber) {
            document.getElementById('editWalletForm').action = "{{ url('member/wallet') }}/" + id;
            document.getElementById('edit_account_number').value = accountNumber;

            if (type === 'trc20') {
                document.getElementById('edit_type_trc20').checked = true;
            } else {
                document.getElementById('edit_type_bep20').checked = true;
            }

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
