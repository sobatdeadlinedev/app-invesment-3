@extends('member.layouts.app')
@section('content')
    <div class="scrollable-content">
        <div class="content-section" style="padding: 0;">

            {{-- COIN HEADER - Seamless tanpa card --}}
            <div class="seamless-header-section">
                <div class="d-flex align-items-center gap-3">
                    <div class="coin-icon-large"
                        style="background: linear-gradient(135deg, {{ $coinInfo['color'] }}33 0%, {{ $coinInfo['color'] }}1a 100%); 
                               border: 2px solid {{ $coinInfo['color'] }}66;">
                        <i class="{{ $coinInfo['icon'] }}" style="color: {{ $coinInfo['color'] }};"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="mb-1 fw-bold" style="color: var(--text-primary); font-size: 18px;">
                            {{ $coinInfo['symbol'] }}
                        </h5>
                        <small class="text-muted">{{ $coinInfo['name'] }}</small>
                    </div>
                    <div class="text-end">
                        <h6 class="text-gold mb-0 fw-bold" style="font-size: 20px;">{{ count($openSignals) }}</h6>
                        <small class="text-muted" style="font-size: 11px;">Open Signals</small>
                    </div>
                </div>
            </div>

            {{-- WARNING NOTICE - Seamless --}}
            @if (!auth()->user()->canJoinSignal())
                <div class="seamless-warning-notice">
                    <div class="d-flex align-items-start gap-3">
                        <div class="warning-icon-wrapper">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold mb-1" style="font-size: 13px; color: #dc3545;">Notice:</div>
                            <p class="mb-0" style="font-size: 12px; color: #dc3545; line-height: 1.6;">
                                Minimum <strong>$ 100.00</strong> available Trade Balance required to join signals.
                                Please <a href="{{ route('member.balance.transfer') }}" class="text-decoration-underline"
                                    style="color: #dc3545; font-weight: 600;">transfer funds</a> first.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- SUCCESS ALERT --}}
            @if (session('success'))
                <div class="seamless-alert seamless-alert-success">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-check-circle-fill" style="font-size: 20px; color: #28a745; flex-shrink: 0;"></i>
                        <div class="flex-grow-1">
                            <p class="mb-0" style="font-size: 13px; color: #28a745;">{{ session('success') }}</p>
                        </div>
                        <button type="button" class="btn-alert-close" onclick="this.parentElement.parentElement.remove()">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
            @endif

            {{-- ERROR ALERT --}}
            @if (session('error'))
                <div class="seamless-alert seamless-alert-danger">
                    <div class="d-flex align-items-start gap-3">
                        <i class="bi bi-exclamation-circle-fill"
                            style="font-size: 20px; color: #dc3545; flex-shrink: 0;"></i>
                        <div class="flex-grow-1">
                            <p class="mb-0" style="font-size: 13px; color: #dc3545;">{{ session('error') }}</p>
                        </div>
                        <button type="button" class="btn-alert-close" onclick="this.parentElement.parentElement.remove()">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                </div>
            @endif

            {{-- CHART SECTION - Full Width Seamless --}}
            <div class="seamless-chart-wrapper">
                <iframe id="tradingViewChart"
                    src="https://www.tradingview.com/widgetembed/?symbol={{ $coinInfo['tradingview_symbol'] }}&interval=60&theme=light&style=1&locale=en&toolbar_bg=F5F5F5&enable_publishing=false&hidesidetoolbar=1&allow_symbol_change=0&show_popup_button=0&details=0&calendar=0&studies=%5B%5D"
                    style="width: 100%; height: 450px; border: none; display: block;" frameborder="0"
                    allowtransparency="true" scrolling="no">
                </iframe>
            </div>

            {{-- TABS NAVIGATION - Seamless Modern --}}
            <div class="seamless-tabs-wrapper">
                <div class="signal-tabs-modern">
                    <button class="tab-btn-modern active" data-tab="signals">
                        <i class="bi bi-broadcast"></i>
                        <span>Trading Signals</span>
                    </button>
                    <button class="tab-btn-modern" data-tab="history">
                        <i class="bi bi-clock-history"></i>
                        <span>Historical Orders</span>
                    </button>
                </div>
            </div>

            {{-- TAB CONTENT: TRADING SIGNALS --}}
            <div class="tab-content active" id="tab-signals">
                <div class="seamless-tab-header">
                    <h6 class="mb-0 fw-bold" style="color: var(--text-primary); font-size: 14px;">Available Trading Signals
                    </h6>
                    <span class="badge-signals-count">{{ count($openSignals) }} Signals</span>
                </div>

                <div class="seamless-signals-list">
                    @forelse($openSignals as $signal)
                        @php
                            $isPending = $signal->result === 'pending' || $signal->result === null;
                            $betAmountPreview = $signal->betAmountPreview ?? 0;
                        @endphp

                        <div class="signal-item-seamless">
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div class="flex-grow-1">
                                        <div class="fw-bold mb-1" style="font-size: 14px; color: var(--text-primary);">
                                            <i class="bi bi-broadcast text-gold me-2"></i>{{ $signal->title }}
                                        </div>
                                        @if ($signal->description)
                                            <small class="text-muted d-block"
                                                style="font-size: 12px;">{{ Str::limit($signal->description, 60) }}</small>
                                        @endif
                                    </div>
                                    <span class="badge-status-open">
                                        <i class="bi bi-circle-fill" style="font-size: 6px;"></i> OPEN
                                    </span>
                                </div>

                                <div class="row g-2">
                                    <div class="col-4">
                                        <small class="text-muted d-block" style="font-size: 10px;">Bet Type</small>
                                        <small class="fw-bold" style="color: var(--text-primary);">
                                            @if ($signal->bet_type == 'percentage')
                                                <span class="badge-bet-type badge-percentage">
                                                    {{ number_format($signal->bet_value, 2) }}%
                                                </span>
                                            @else
                                                <span class="badge-bet-type badge-fixed">
                                                    {{ number_format($signal->bet_value, 2) }} USDT
                                                </span>
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted d-block" style="font-size: 10px;">Your Bet</small>
                                        <small class="text-gold fw-bold" style="font-size: 13px;">
                                            $ {{ number_format($betAmountPreview, 2) }}
                                        </small>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted d-block" style="font-size: 10px;">Participants</small>
                                        <small class="fw-bold" style="color: var(--text-primary); font-size: 13px;">
                                            {{ $signal->participants_count }}
                                        </small>
                                    </div>
                                </div>

                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block" style="font-size: 10px;">Opening Price</small>
                                        <small class="fw-bold" style="color: var(--text-primary); font-size: 12px;">
                                            @if ($isPending || !$signal->entry_price)
                                                ~
                                            @else
                                                $ {{ number_format($signal->entry_price, 2) }}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block" style="font-size: 10px;">Settlement
                                            Price</small>
                                        <small class="text-gold fw-bold" style="font-size: 12px;">
                                            @if ($isPending || !$signal->target_price)
                                                ~
                                            @else
                                                $ {{ number_format($signal->target_price, 2) }}
                                            @endif
                                        </small>
                                    </div>
                                </div>

                                <div class="signal-action-footer">
                                    @if (in_array($signal->id, $joinedSignalIds))
                                        <span class="badge-joined">
                                            <i class="bi bi-check-circle me-1"></i>Joined
                                        </span>
                                    @else
                                        <a href="{{ route('member.invest.detail', ['signal_id' => $signal->id]) }}"
                                            class="btn btn-gold btn-sm" style="font-size: 11px; padding: 6px 16px;">
                                            <i class="bi bi-eye me-1"></i>View Detail
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="seamless-empty-state">
                            <i class="bi bi-broadcast-pin"></i>
                            <p class="mb-1">No open signals for {{ $coinInfo['name'] }}</p>
                            <small>Check back later for new trading signals</small>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- TAB CONTENT: HISTORICAL ORDERS --}}
            <div class="tab-content" id="tab-history">
                <div class="seamless-tab-header">
                    <h6 class="mb-0 fw-bold" style="color: var(--text-primary); font-size: 14px;">Your Historical Orders
                    </h6>
                    <span class="badge-signals-count">3 Orders</span>
                </div>

                <div class="seamless-history-list">
                    {{-- Historical Data --}}
                    <div class="history-item">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="flex-grow-1">
                                <div class="fw-bold mb-1" style="font-size: 14px; color: var(--text-primary);">
                                    BTC Long Signal #1234
                                </div>
                                <small class="text-muted" style="font-size: 11px;">Jan 15, 2026 - 14:30</small>
                            </div>
                            <span class="badge-status-won">
                                <i class="bi bi-check-circle me-1"></i>WON
                            </span>
                        </div>
                        <div class="row g-2">
                            <div class="col-4">
                                <small class="text-muted d-block" style="font-size: 10px;">Bet Amount</small>
                                <small class="fw-bold" style="color: var(--text-primary); font-size: 12px;">$
                                    150.00</small>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block" style="font-size: 10px;">Reward</small>
                                <small class="fw-bold" style="color: #28a745; font-size: 12px;">$ 45.00</small>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block" style="font-size: 10px;">Profit</small>
                                <small class="fw-bold" style="color: #28a745; font-size: 12px;">+30%</small>
                            </div>
                        </div>
                    </div>

                    <div class="history-item">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="flex-grow-1">
                                <div class="fw-bold mb-1" style="font-size: 14px; color: var(--text-primary);">
                                    ETH Short Signal #1233
                                </div>
                                <small class="text-muted" style="font-size: 11px;">Jan 14, 2026 - 09:15</small>
                            </div>
                            <span class="badge-status-won">
                                <i class="bi bi-check-circle me-1"></i>WON
                            </span>
                        </div>
                        <div class="row g-2">
                            <div class="col-4">
                                <small class="text-muted d-block" style="font-size: 10px;">Bet Amount</small>
                                <small class="fw-bold" style="color: var(--text-primary); font-size: 12px;">$
                                    200.00</small>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block" style="font-size: 10px;">Reward</small>
                                <small class="fw-bold" style="color: #28a745; font-size: 12px;">$ 80.00</small>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block" style="font-size: 10px;">Profit</small>
                                <small class="fw-bold" style="color: #28a745; font-size: 12px;">+40%</small>
                            </div>
                        </div>
                    </div>

                    <div class="history-item">
                        <div class="d-flex align-items-start justify-content-between mb-2">
                            <div class="flex-grow-1">
                                <div class="fw-bold mb-1" style="font-size: 14px; color: var(--text-primary);">
                                    BTC Scalp Signal #1232
                                </div>
                                <small class="text-muted" style="font-size: 11px;">Jan 12, 2026 - 16:45</small>
                            </div>
                            <span class="badge-status-won">
                                <i class="bi bi-check-circle me-1"></i>WON
                            </span>
                        </div>
                        <div class="row g-2">
                            <div class="col-4">
                                <small class="text-muted d-block" style="font-size: 10px;">Bet Amount</small>
                                <small class="fw-bold" style="color: var(--text-primary); font-size: 12px;">$
                                    100.00</small>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block" style="font-size: 10px;">Reward</small>
                                <small class="fw-bold" style="color: #28a745; font-size: 12px;">$ 25.00</small>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block" style="font-size: 10px;">Profit</small>
                                <small class="fw-bold" style="color: #28a745; font-size: 12px;">+25%</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="seamless-footer-info">
                    <small>Total Historical Orders: 3</small>
                </div>
            </div>

            {{-- INFO SECTION - Seamless --}}
            <div class="seamless-info-section">
                <div class="d-flex align-items-start gap-3">
                    <i class="bi bi-info-circle-fill text-gold"
                        style="font-size: 20px; margin-top: 2px; flex-shrink: 0;"></i>
                    <div>
                        <h6 class="mb-2 fw-bold" style="font-size: 13px; color: var(--text-primary);">How It Works</h6>
                        <ul class="small text-muted mb-0 ps-3" style="font-size: 12px; line-height: 1.8;">
                            <li>View signal details before joining</li>
                            <li>Bet amount varies by signal: <strong
                                    style="color: var(--text-primary);">percentage-based</strong> or <strong
                                    style="color: var(--text-primary);">fixed
                                    amount</strong></li>
                            <li>Percentage signals: bet = % of your Trade Balance</li>
                            <li>Fixed signals: same bet amount for all users</li>
                            <li>Minimum $ 100.00 available balance required (for percentage signals)</li>
                            <li>Your bet will be locked until settlement</li>
                            <li><strong style="color: #28a745;">You always win rewards!</strong> No losses, no fees</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @push('styles')
        <style>
            /* Seamless Header Section */
            .seamless-header-section {
                padding: 20px;
                background: transparent;
                border-bottom: 1px solid var(--border-color);
            }

            /* Seamless Warning Notice */
            .seamless-warning-notice {
                padding: 16px 20px;
                background: rgba(220, 53, 69, 0.05);
                border-bottom: 1px solid rgba(220, 53, 69, 0.2);
            }

            .warning-icon-wrapper {
                width: 40px;
                height: 40px;
                background: rgba(220, 53, 69, 0.15);
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }

            .warning-icon-wrapper i {
                font-size: 20px;
                color: #dc3545;
            }

            /* Seamless Alerts */
            .seamless-alert {
                padding: 14px 20px;
                border-bottom: 1px solid;
            }

            .seamless-alert-success {
                background: rgba(40, 167, 69, 0.05);
                border-color: rgba(40, 167, 69, 0.2);
            }

            .seamless-alert-danger {
                background: rgba(220, 53, 69, 0.05);
                border-color: rgba(220, 53, 69, 0.2);
            }

            .btn-alert-close {
                background: transparent;
                border: none;
                width: 28px;
                height: 28px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                border-radius: 50%;
                transition: all 0.2s ease;
                padding: 0;
                flex-shrink: 0;
            }

            .btn-alert-close:hover {
                background: rgba(0, 0, 0, 0.1);
            }

            .btn-alert-close i {
                font-size: 20px;
                color: var(--text-muted);
            }

            /* Seamless Chart Wrapper */
            .seamless-chart-wrapper {
                background: transparent;
                overflow: hidden;
                border-bottom: 1px solid var(--border-color);
            }

            /* Seamless Tabs Wrapper */
            .seamless-tabs-wrapper {
                padding: 0;
                background: transparent;
                border-bottom: 1px solid var(--border-color);
            }

            /* Signal Tabs Modern */
            .signal-tabs-modern {
                display: flex;
                gap: 0;
                background: transparent;
                padding: 0;
                margin: 0;
            }

            .tab-btn-modern {
                flex: 1;
                padding: 16px 20px;
                background: transparent;
                border: none;
                color: var(--text-muted);
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.2s ease;
                border-bottom: 3px solid transparent;
                display: flex;
                align-items: center;
                justify-content: center;
                gap: 8px;
            }

            .tab-btn-modern i {
                font-size: 16px;
            }

            .tab-btn-modern:hover {
                color: var(--text-primary);
                background: rgba(169, 126, 0, 0.03);
            }

            .tab-btn-modern.active {
                color: var(--gold-color);
                border-bottom-color: var(--gold-color);
                background: transparent;
            }

            /* Seamless Tab Header */
            .seamless-tab-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 16px 20px;
                background: transparent;
                border-bottom: 1px solid var(--border-color);
            }

            /* Badge Signals Count */
            .badge-signals-count {
                background: transparent;
                border: 1px solid var(--gold-color);
                color: var(--gold-color);
                padding: 4px 10px;
                border-radius: 12px;
                font-size: 11px;
                font-weight: 600;
            }

            /* Seamless Signals List */
            .seamless-signals-list {
                background: transparent;
            }

            /* Signal Item Seamless */
            .signal-item-seamless {
                background: transparent;
                border: none;
                border-bottom: 1px solid var(--border-color);
                border-radius: 0;
                padding: 16px 20px;
                margin-bottom: 0;
                transition: all 0.2s ease;
            }

            .signal-item-seamless:last-child {
                border-bottom: none;
            }

            .signal-item-seamless:hover {
                background: rgba(169, 126, 0, 0.03);
                box-shadow: none;
                transform: none;
            }

            /* History Item */
            .history-item {
                background: transparent;
                border: none;
                border-bottom: 1px solid var(--border-color);
                border-radius: 0;
                padding: 16px 20px;
                margin-bottom: 0;
                transition: all 0.2s ease;
            }

            .history-item:last-child {
                border-bottom: none;
            }

            .history-item:hover {
                background: rgba(169, 126, 0, 0.03);
                box-shadow: none;
                transform: none;
            }

            /* Seamless History List */
            .seamless-history-list {
                background: transparent;
            }

            /* Signal Action Footer */
            .signal-action-footer {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                padding-top: 12px;
                margin-top: 8px;
                border-top: 1px solid var(--border-color);
            }

            /* Badge Styles */
            .badge-status-open {
                background: rgba(40, 167, 69, 0.15);
                color: #28a745;
                font-size: 10px;
                padding: 4px 8px;
                border-radius: 6px;
                display: inline-block;
                white-space: nowrap;
            }

            .badge-status-won {
                background: rgba(40, 167, 69, 0.15);
                color: #28a745;
                font-size: 10px;
                padding: 4px 8px;
                border-radius: 6px;
                display: inline-block;
                white-space: nowrap;
            }

            .badge-joined {
                background: rgba(13, 110, 253, 0.15);
                color: #0d6efd;
                font-size: 11px;
                padding: 6px 12px;
                border-radius: 6px;
                display: inline-block;
            }

            .badge-bet-type {
                font-size: 9px;
                padding: 3px 6px;
                border-radius: 4px;
                display: inline-block;
            }

            .badge-percentage {
                background: rgba(13, 110, 253, 0.15);
                color: #0d6efd;
            }

            .badge-fixed {
                background: rgba(13, 202, 240, 0.15);
                color: #0dcaf0;
            }

            /* Seamless Empty State */
            .seamless-empty-state {
                padding: 60px 20px;
                text-align: center;
                background: transparent;
            }

            .seamless-empty-state i {
                font-size: 48px;
                color: var(--border-color);
                display: block;
                margin-bottom: 12px;
            }

            .seamless-empty-state p {
                color: var(--text-muted);
                font-size: 14px;
                margin: 0;
            }

            .seamless-empty-state small {
                color: var(--text-muted);
                font-size: 12px;
            }

            /* Seamless Footer Info */
            .seamless-footer-info {
                padding: 20px;
                text-align: center;
                background: transparent;
                border-top: 1px solid var(--border-color);
            }

            .seamless-footer-info small {
                color: var(--text-muted);
                font-size: 12px;
            }

            /* Seamless Info Section */
            .seamless-info-section {
                padding: 20px;
                background: linear-gradient(135deg, rgba(169, 126, 0, 0.05) 0%, rgba(169, 126, 0, 0.02) 100%);
                border-top: 1px solid rgba(169, 126, 0, 0.2);
                margin-top: 0;
            }

            /* Tab Content */
            .tab-content {
                display: none;
            }

            .tab-content.active {
                display: block;
                animation: fadeIn 0.3s ease;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(10px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    @endpush>

    @push('scripts')
        <script>
            // Tab Switcher
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Tab switcher initialized');

                // Function untuk show tab
                function showTab(tabName) {
                    console.log('Showing tab:', tabName);

                    // Hide semua tab content
                    document.querySelectorAll('.tab-content').forEach(content => {
                        content.style.display = 'none';
                        content.classList.remove('active');
                    });

                    // Remove active dari semua tab buttons
                    document.querySelectorAll('.tab-btn-modern').forEach(btn => {
                        btn.classList.remove('active');
                    });

                    // Show tab yang dipilih
                    const targetContent = document.getElementById('tab-' + tabName);
                    const targetButton = document.querySelector(`[data-tab="${tabName}"]`);

                    if (targetContent) {
                        targetContent.style.display = 'block';
                        targetContent.classList.add('active');
                        console.log('Tab content shown:', tabName);
                    } else {
                        console.error('Tab content not found:', tabName);
                    }

                    if (targetButton) {
                        targetButton.classList.add('active');
                        console.log('Tab button activated:', tabName);
                    }
                }

                // Initial setup - show first tab (signals)
                showTab('signals');

                // Event listener untuk semua tab buttons
                document.querySelectorAll('.tab-btn-modern').forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        const tabName = this.getAttribute('data-tab');
                        console.log('Tab button clicked:', tabName);
                        showTab(tabName);
                    });
                });

                // Auto hide alerts after 5 seconds
                setTimeout(function() {
                    const alerts = document.querySelectorAll('.seamless-alert');
                    alerts.forEach(alert => {
                        alert.style.transition = 'opacity 0.5s ease';
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 500);
                    });
                }, 5000);

                console.log('Tab switcher setup complete');
            });
        </script>
    @endpush
@endsection
