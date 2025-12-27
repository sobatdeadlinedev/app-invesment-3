@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <!-- Back Button -->
            <div class="mb-3">
                <a href="{{ route('member.invest.index') }}" class="btn-back">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
            </div>

            <!-- Coin Header Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <div class="coin-icon-large btc">
                        <i class="bi bi-currency-bitcoin"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="text-white mb-1 fw-bold">BTC/USDT</h5>
                        <small class="text-muted">Bitcoin</small>
                    </div>
                </div>
                <div class="d-flex align-items-end justify-content-between">
                    <div>
                        <p class="text-muted mb-1 small">Current Price</p>
                        <h3 class="text-gold mb-0 fw-bold">$43,250.50</h3>
                    </div>
                    <div class="text-end">
                        <small class="price-change-large positive">+2.45%</small>
                        <div class="text-muted small mt-1">24h Change</div>
                    </div>
                </div>
            </div>

            <!-- Chart Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="text-white mb-0">Price Chart</h6>
                    <div class="chart-timeframe-pills">
                        <button class="timeframe-pill active">1H</button>
                        <button class="timeframe-pill">1D</button>
                        <button class="timeframe-pill">1W</button>
                    </div>
                </div>

                <!-- Simple Chart Placeholder -->
                <div class="chart-container">
                    <canvas id="priceChart"></canvas>
                </div>
            </div>

            <!-- Trading Amount Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <h6 class="text-white mb-3">Trading Amount</h6>
                <div class="mb-3">
                    <label class="text-muted small mb-2 d-block">Amount (USD)</label>
                    <input type="number" class="form-control-dark" placeholder="Enter amount" value="100">
                </div>
                <div class="amount-quick-select">
                    <button class="quick-amount-btn">$50</button>
                    <button class="quick-amount-btn">$100</button>
                    <button class="quick-amount-btn">$250</button>
                    <button class="quick-amount-btn">$500</button>
                </div>
            </div>

            <!-- Trading Duration Card -->
            <div class="card-dark shadow-sm p-3 mb-3">
                <h6 class="text-white mb-3">Trading Duration</h6>
                <div class="duration-options">
                    <button class="duration-btn active">
                        <div class="duration-time">1 Min</div>
                        <div class="duration-payout">85%</div>
                    </button>
                    <button class="duration-btn">
                        <div class="duration-time">5 Min</div>
                        <div class="duration-payout">88%</div>
                    </button>
                    <button class="duration-btn">
                        <div class="duration-time">15 Min</div>
                        <div class="duration-payout">92%</div>
                    </button>
                    <button class="duration-btn">
                        <div class="duration-time">30 Min</div>
                        <div class="duration-payout">95%</div>
                    </button>
                </div>
            </div>

            <!-- Trading Buttons -->
            <div class="row g-3 mb-3">
                <div class="col-6">
                    <button class="btn btn-call w-100">
                        <i class="bi bi-arrow-up-circle me-2"></i>CALL
                    </button>
                </div>
                <div class="col-6">
                    <button class="btn btn-put w-100">
                        <i class="bi bi-arrow-down-circle me-2"></i>PUT
                    </button>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Simple Chart Implementation
        const ctx = document.getElementById('priceChart').getContext('2d');

        // Generate sample data
        const generateData = () => {
            const data = [];
            let value = 43000;
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
                                return '$' + value.toLocaleString();
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

        // Timeframe buttons
        document.querySelectorAll('.timeframe-pill').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.timeframe-pill').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                // Update chart data here
                chart.data.datasets[0].data = generateData();
                chart.update();
            });
        });

        // Duration buttons
        document.querySelectorAll('.duration-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.duration-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Quick amount buttons
        document.querySelectorAll('.quick-amount-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const amount = this.textContent.replace('$', '');
                document.querySelector('.form-control-dark').value = amount;
            });
        });
    </script>
@endsection
