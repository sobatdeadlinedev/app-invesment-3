@extends('member.layouts.app')
@section('content')
    <div class="scrollable-content">
        <div class="content-section">

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

            <div class="mb-3">
                <a href="{{ route('member.invest.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i>Back to Signals
                </a>
            </div>

            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="row g-3">
                    <div class="col-4">
                        <p class="text-muted mb-1 small">Trade Balance</p>
                        <h6 class="text-white mb-0 fw-bold">$ {{ number_format(auth()->user()->trade_balance, 2) }}</h6>
                    </div>
                    <div class="col-4">
                        <p class="text-muted mb-1 small">Available</p>
                        <h6 class="text-success mb-0 fw-bold">$
                            {{ number_format(auth()->user()->getAvailableTradeBalance(), 2) }}</h6>
                    </div>
                    <div class="col-4">
                        <p class="text-muted mb-1 small">Locked</p>
                        <h6 class="text-warning mb-0 fw-bold">$ {{ number_format(auth()->user()->locked_balance, 2) }}</h6>
                    </div>
                </div>
            </div>

            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="coin-icon-large" style="background: linear-gradient(135deg, #f5a623 0%, #f7b733 100%);">
                        <i class="bi bi-broadcast"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="text-white mb-1 fw-bold">{{ $signal->title }}</h5>
                        <small class="text-muted">Trading Signal</small>
                    </div>
                    @if ($signal->status === 'open')
                        <span class="badge badge-success">
                            <i class="bi bi-circle-fill" style="font-size: 6px;"></i> OPEN
                        </span>
                    @elseif($signal->status === 'closed')
                        <span class="badge badge-warning">
                            <i class="bi bi-circle-fill" style="font-size: 6px;"></i> CLOSED
                        </span>
                    @else
                        <span class="badge badge-secondary">SETTLED</span>
                    @endif
                </div>

                @if ($signal->description)
                    <div class="mb-3">
                        <p class="text-muted small mb-0">{{ $signal->description }}</p>
                    </div>
                @endif

                @if ($signal->status != 'settled')
                    <div class="d-flex align-items-end justify-content-between">
                        <div class="row g-3 flex-grow-1">
                            @if ($signal->entry_price)
                                <div class="col-6">
                                    <p class="text-muted mb-1 small">Opening Price</p>
                                    <h6 class="text-gold mb-0 fw-bold">~</h6>
                                </div>
                            @endif
                            @if ($signal->target_price)
                                <div class="col-6">
                                    <p class="text-muted mb-1 small">Settlement Price</p>
                                    <h6 class="text-success mb-0 fw-bold">~</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="d-flex align-items-end justify-content-between">
                        <div class="row g-3 flex-grow-1">
                            @if ($signal->entry_price)
                                <div class="col-6">
                                    <p class="text-muted mb-1 small">Opening Price</p>
                                    <h6 class="text-gold mb-0 fw-bold">$ {{ number_format($signal->entry_price, 2) }}</h6>
                                </div>
                            @endif
                            @if ($signal->target_price)
                                <div class="col-6">
                                    <p class="text-muted mb-1 small">Settlement Price</p>
                                    <h6 class="text-success mb-0 fw-bold">$ {{ number_format($signal->target_price, 2) }}
                                    </h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="text-white mb-0">Signal Activity</h6>
                    <div class="chart-timeframe-pills">
                        <button class="timeframe-pill active">1H</button>
                        <button class="timeframe-pill">1D</button>
                        <button class="timeframe-pill">1W</button>
                    </div>
                </div>

                <div class="chart-container">
                    <canvas id="priceChart"></canvas>
                </div>
            </div>

            @if ($hasJoined)
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white mb-3">
                        <i class="bi bi-check-circle text-success me-2"></i>Your Participation
                    </h6>
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="text-muted mb-1 small">Bet Amount</p>
                            <h6 class="text-white mb-0 fw-bold">$ {{ number_format($participant->bet_amount, 2) }}</h6>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1 small">Status</p>
                            @if ($participant->status === 'joined')
                                <span class="badge badge-warning">
                                    <i class="bi bi-clock me-1"></i>Waiting Settlement
                                </span>
                            @else
                                <span class="badge badge-success">
                                    <i class="bi bi-check-circle me-1"></i>Settled
                                </span>
                            @endif
                        </div>
                    </div>

                    @if ($participant->status === 'settled')
                        <div class="mt-3 pt-3" style="border-top: 1px solid var(--border-color);">
                            <div class="row g-3">
                                <div class="col-12">
                                    <p class="text-muted mb-1 small">Your Reward</p>
                                    <h6 class="text-success mb-0 fw-bold">
                                        + $ {{ number_format($participant->profit_loss, 2) }}
                                    </h6>
                                    <small class="text-muted">You received
                                        {{ number_format(($participant->profit_loss / $participant->bet_amount) * 100, 2) }}%
                                        reward</small>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            @if (!$hasJoined && $signal->status === 'open')
                <div class="card-dark shadow-sm p-3 mb-3">
                    <h6 class="text-white mb-3">Your Bet Calculation</h6>
                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <p class="text-muted mb-1 small">Current Trade Balance</p>
                            <h6 class="text-white mb-0 fw-bold">$ {{ number_format(auth()->user()->trade_balance, 2) }}
                            </h6>
                        </div>
                        <div class="col-6">
                            <p class="text-muted mb-1 small">Bet Amount (1%)</p>
                            <h6 class="text-gold mb-0 fw-bold">$
                                {{ number_format(auth()->user()->calculateBetAmount(), 2) }}</h6>
                        </div>
                    </div>
                    <div class="alert"
                        style="background-color: rgba(34, 197, 94, 0.1); border: 1px solid #22c55e; color: #22c55e; font-size: 12px;">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Good news!</strong> You will always receive rewards based on the win rate. No losses, no
                        fees!
                        Your bet is just locked temporarily for volume tracking.
                    </div>
                </div>
            @endif

            <div class="card-dark shadow-sm p-3 mb-3">
                <h6 class="text-white mb-3">Signal Statistics</h6>
                <div class="row g-3">
                    <div class="col-4">
                        <p class="text-muted mb-1 small">Participants</p>
                        <h6 class="text-white mb-0 fw-bold">
                            <i class="bi bi-people me-1"></i>{{ $signal->total_participants }}
                        </h6>
                    </div>
                    <div class="col-4">
                        <p class="text-muted mb-1 small">Total Bets</p>
                        <h6 class="text-white mb-0 fw-bold">$ {{ number_format($signal->total_bet_amount, 2) }}</h6>
                    </div>
                    <div class="col-4">
                        <p class="text-muted mb-1 small">Opened</p>
                        <h6 class="text-white mb-0 fw-bold">{{ $signal->opened_at->format('H:i') }}</h6>
                    </div>
                </div>

                @if ($signal->status !== 'open')
                    <div class="mt-3 pt-3" style="border-top: 1px solid var(--border-color);">
                        <div class="row g-3">
                            <div class="col-6">
                                <p class="text-muted mb-1 small">Result</p>
                                @if ($signal->result === 'call')
                                    <span class="badge badge-success">
                                        <i class="bi bi-arrow-up me-1"></i>CALL (Market Up)
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="bi bi-arrow-down me-1"></i>PUT (Market Down)
                                    </span>
                                @endif
                            </div>
                            <div class="col-6">
                                <p class="text-muted mb-1 small">Win Rate</p>
                                <h6 class="text-gold mb-0 fw-bold">{{ number_format($signal->rate_of_return, 2) }}%</h6>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if (!$hasJoined && $signal->status === 'open')
                @if (auth()->user()->canJoinSignal())
                    <form action="{{ route('member.signals.join', $signal->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-call w-100"
                            onclick="return confirm('Join this signal?\n\nYour bet: ${{ number_format(auth()->user()->calculateBetAmount(), 2) }} will be locked until settlement.\n\nYou will receive rewards based on the win rate set by admin.\n\nDo you want to continue?')">
                            <i class="bi bi-check-circle me-2"></i>JOIN THIS SIGNAL
                        </button>
                    </form>
                @else
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Insufficient Balance:</strong> Minimum $100.00 available Trade Balance required.
                        <a href="{{ route('member.balance.transfer') }}" class="text-white"><u>Transfer funds now</u></a>
                    </div>
                @endif
            @elseif($hasJoined)
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>
                    You have joined this signal. Wait for admin to settle and receive your rewards!
                </div>
            @else
                <div class="alert alert-secondary">
                    <i class="bi bi-lock me-2"></i>
                    This signal is no longer available for joining.
                </div>
            @endif

            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-start gap-2">
                    <i class="bi bi-info-circle-fill text-gold" style="font-size: 18px; margin-top: 2px;"></i>
                    <div>
                        <h6 class="text-white mb-1" style="font-size: 13px;">Important Information</h6>
                        <ul class="small text-muted mb-0 ps-3" style="font-size: 12px;">
                            <li>Bet is automatically calculated as 1% of Trade Balance</li>
                            <li>Minimum $100.00 available balance required</li>
                            <li>Your bet will be locked until signal settlement</li>
                            <li><strong class="text-success">No losses! No fees!</strong> You always win rewards</li>
                            <li>Reward amount depends on the win rate set by admin</li>
                            <li>Call/Put indicates market direction (both receive rewards)</li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('priceChart').getContext('2d');

        const generateData = () => {
            const data = [];
            let value = {{ $signal->entry_price ?? 43000 }};
            for (let i = 0; i < 20; i++) {
                value += (Math.random() - 0.5) * 500;
                data.push(value);
            }
            return data;
        };

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Array.from({
                    length: 20
                }, (_, i) => ''),
                datasets: [{
                    label: 'Price',
                    data: generateData(),
                    borderColor: '#f5a623',
                    backgroundColor: 'rgba(245, 166, 35, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0,
                    pointHoverRadius: 4,
                    pointHoverBackgroundColor: '#f5a623',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(29, 32, 88, 0.95)',
                        titleColor: '#f5a623',
                        bodyColor: '#ffffff',
                        borderColor: '#f5a623',
                        borderWidth: 1
                    }
                },
                scales: {
                    x: {
                        display: false
                    },
                    y: {
                        display: true,
                        grid: {
                            color: 'rgba(61, 65, 112, 0.3)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#a5a8c4',
                            font: {
                                size: 11
                            },
                            callback: function(value) {
                                return ' + value.toLocaleString();
                            }
                        }
                    }
                },
                interaction: {
                    mode: 'index',
                    intersect: false
                }
            }
        });

        document.querySelectorAll('.timeframe-pill').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.timeframe-pill').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                chart.data.datasets[0].data = generateData();
                chart.update();
            });
        });

        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    </script>
@endsection
