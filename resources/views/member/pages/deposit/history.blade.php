@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('member.profile.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i>{{ __('app.back') }}
                </a>
            </div>

            <h5 class="text-white mb-3">{{ __('app.deposit_history') }}</h5>

            <!-- Summary Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <div class="summary-icon-wrapper pending">
                                <i class="bi bi-clock-history"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small">{{ __('app.pending') }}</p>
                                <h6 class="text-white mb-0 fw-bold">{{ $pendingCount }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center gap-2">
                            <div class="summary-icon-wrapper completed">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div>
                                <p class="text-muted mb-0 small">{{ __('app.completed') }}</p>
                                <h6 class="text-white mb-0 fw-bold">{{ $completedCount }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs mb-3">
                <button class="filter-tab active" onclick="filterTransactions('all')">
                    {{ __('app.all') }}
                </button>
                <button class="filter-tab" onclick="filterTransactions('pending')">
                    {{ __('app.pending') }}
                </button>
                <button class="filter-tab" onclick="filterTransactions('approved')">
                    {{ __('app.approved') }}
                </button>
                <button class="filter-tab" onclick="filterTransactions('rejected')">
                    {{ __('app.rejected') }}
                </button>
                <button class="filter-tab" onclick="filterTransactions('completed')">
                    {{ __('app.completed') }}
                </button>
            </div>

            <!-- Transactions List -->
            <div class="card-dark shadow-sm">
                @forelse($transactions as $transaction)
                    <div class="deposit-item" data-status="{{ $transaction->status }}">
                        <div class="d-flex align-items-start gap-3">
                            <!-- Icon -->
                            <div class="deposit-icon-wrapper {{ $transaction->status }}">
                                @if ($transaction->status === 'pending')
                                    <i class="bi bi-clock-history"></i>
                                @elseif($transaction->status === 'approved')
                                    <i class="bi bi-hourglass-split"></i>
                                @elseif($transaction->status === 'completed')
                                    <i class="bi bi-check-circle"></i>
                                @else
                                    <i class="bi bi-x-circle"></i>
                                @endif
                            </div>

                            <!-- Content -->
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-1">
                                    <div>
                                        <h6 class="text-white mb-0 fw-bold">{{ __('app.deposit') }}</h6>
                                        <p class="text-muted small mb-0">{{ $transaction->reference }}</p>
                                    </div>
                                    <div class="text-end">
                                        <h6 class="text-success mb-0 fw-bold">+{{ number_format($transaction->amount, 2) }}
                                            USDT</h6>
                                        <span class="status-badge {{ $transaction->status }}">
                                            {{ __('app.' . $transaction->status) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Transaction Details -->
                                <div class="transaction-details mt-2">
                                    {{-- <div class="detail-row">
                                        <span class="text-muted small">{{ __('app.payment_method') }}:</span>
                                        <span class="text-white small fw-bold">
                                            {{ __('app.' . str_replace(' ', '_', strtolower($transaction->payment_method))) }}
                                        </span>
                                    </div> --}}
                                    <div class="detail-row">
                                        <span class="text-muted small">{{ __('app.amount') }}:</span>
                                        <span class="text-success small fw-bold">
                                            {{ number_format($transaction->total_amount, 2) }} USDT
                                        </span>
                                    </div>
                                    <div class="detail-row">
                                        <span class="text-muted small">{{ __('app.date') }}:</span>
                                        <span class="text-white small">
                                            {{ $transaction->created_at->format('d M Y, H:i') }}
                                        </span>
                                    </div>
                                    @if (in_array($transaction->status, ['approved', 'completed']) && $transaction->updated_at)
                                        <div class="detail-row">
                                            <span class="text-muted small">{{ __('app.processed_at') }}:</span>
                                            <span class="text-white small">
                                                {{ $transaction->updated_at->format('d M Y, H:i') }}
                                            </span>
                                        </div>
                                    @endif
                                    @if ($transaction->payment_proof)
                                        <div class="detail-row">
                                            <span class="text-muted small">{{ __('app.payment_proof') }}:</span>
                                            <button type="button" class="btn-view-proof"
                                                onclick="viewProof('{{ asset('storage/' . $transaction->payment_proof) }}')">
                                                <i class="bi bi-eye me-1"></i>{{ __('app.view') }}
                                            </button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p class="text-muted mb-0">{{ __('app.no_deposit_history') }}</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if ($transactions->hasPages())
                <div class="mt-3">
                    {{ $transactions->links() }}
                </div>
            @endif

        </div>
    </div>

    <!-- Modal for Payment Proof -->
    <div class="modal fade" id="proofModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: var(--card-dark); border: 1px solid var(--border-color);">
                <div class="modal-header" style="border-bottom: 1px solid var(--border-color);">
                    <h5 class="modal-title text-white">{{ __('app.payment_proof') }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="proofImage" src="" alt="{{ __('app.payment_proof') }}"
                        style="max-width: 100%; border-radius: 8px;">
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Summary Icon Wrapper */
        .summary-icon-wrapper {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            flex-shrink: 0;
        }

        .summary-icon-wrapper i {
            font-size: 20px;
        }

        .summary-icon-wrapper.pending {
            background: rgba(255, 193, 7, 0.15);
            border-color: rgba(255, 193, 7, 0.3);
        }

        .summary-icon-wrapper.pending i {
            color: #ffc107;
        }

        .summary-icon-wrapper.completed {
            background: rgba(40, 167, 69, 0.15);
            border-color: rgba(40, 167, 69, 0.3);
        }

        .summary-icon-wrapper.completed i {
            color: #28a745;
        }

        /* Filter Tabs */
        .filter-tabs {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            padding-bottom: 5px;
        }

        .filter-tabs::-webkit-scrollbar {
            height: 4px;
        }

        .filter-tabs::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        .filter-tab {
            padding: 8px 16px;
            background: rgba(245, 166, 35, 0.1);
            border: 1px solid rgba(245, 166, 35, 0.3);
            border-radius: 6px;
            color: var(--text-muted);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .filter-tab:hover {
            background: rgba(245, 166, 35, 0.15);
        }

        .filter-tab.active {
            background: var(--gold-color);
            border-color: var(--gold-color);
            color: #000;
        }

        /* Deposit Item */
        .deposit-item {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            transition: background-color 0.2s ease;
        }

        .deposit-item:hover {
            background-color: rgba(245, 166, 35, 0.05);
        }

        .deposit-item:last-child {
            border-bottom: none;
        }

        /* Deposit Icon Wrapper */
        .deposit-icon-wrapper {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid;
            flex-shrink: 0;
        }

        .deposit-icon-wrapper i {
            font-size: 22px;
        }

        .deposit-icon-wrapper.pending {
            background: rgba(255, 193, 7, 0.15);
            border-color: rgba(255, 193, 7, 0.3);
        }

        .deposit-icon-wrapper.pending i {
            color: #ffc107;
        }

        .deposit-icon-wrapper.approved {
            background: rgba(59, 181, 232, 0.15);
            border-color: rgba(59, 181, 232, 0.3);
        }

        .deposit-icon-wrapper.approved i {
            color: var(--blue-color);
        }

        .deposit-icon-wrapper.completed {
            background: rgba(40, 167, 69, 0.15);
            border-color: rgba(40, 167, 69, 0.3);
        }

        .deposit-icon-wrapper.completed i {
            color: #28a745;
        }

        .deposit-icon-wrapper.rejected {
            background: rgba(220, 53, 69, 0.15);
            border-color: rgba(220, 53, 69, 0.3);
        }

        .deposit-icon-wrapper.rejected i {
            color: #dc3545;
        }

        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-badge.pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .status-badge.approved {
            background: rgba(59, 181, 232, 0.15);
            color: var(--blue-color);
            border: 1px solid rgba(59, 181, 232, 0.3);
        }

        .status-badge.completed {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-badge.rejected {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        /* Transaction Details */
        .transaction-details {
            background: rgba(245, 166, 35, 0.05);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            padding: 10px 12px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 4px 0;
        }

        .detail-row:not(:last-child) {
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* View Proof Button */
        .btn-view-proof {
            padding: 4px 10px;
            background: rgba(59, 181, 232, 0.1);
            border: 1px solid rgba(59, 181, 232, 0.3);
            border-radius: 4px;
            color: var(--blue-color);
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-view-proof:hover {
            background: rgba(59, 181, 232, 0.2);
            border-color: rgba(59, 181, 232, 0.5);
        }

        /* Empty State */
        .empty-state {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-state i {
            font-size: 64px;
            color: var(--text-muted);
            opacity: 0.5;
            margin-bottom: 16px;
            display: block;
        }

        .empty-state p {
            font-size: 14px;
        }

        /* Responsive */
        @media (max-width: 375px) {
            .deposit-icon-wrapper {
                width: 40px;
                height: 40px;
            }

            .deposit-icon-wrapper i {
                font-size: 20px;
            }

            .summary-icon-wrapper {
                width: 36px;
                height: 36px;
            }

            .summary-icon-wrapper i {
                font-size: 18px;
            }

            .filter-tab {
                padding: 6px 12px;
                font-size: 12px;
            }
        }
    </style>

    <script>
        // Filter transactions
        function filterTransactions(status) {
            // Update active tab
            document.querySelectorAll('.filter-tab').forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.classList.add('active');

            // Filter items
            const items = document.querySelectorAll('.deposit-item');
            items.forEach(item => {
                if (status === 'all') {
                    item.style.display = 'block';
                } else {
                    if (item.dataset.status === status) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                }
            });
        }

        // View payment proof
        function viewProof(imageUrl) {
            document.getElementById('proofImage').src = imageUrl;
            const modal = new bootstrap.Modal(document.getElementById('proofModal'));
            modal.show();
        }

        // Show alert messages
        @if (session('success'))
            alert('{{ session('success') }}');
        @endif

        @if (session('error'))
            alert('{{ session('error') }}');
        @endif
    </script>
@endsection
