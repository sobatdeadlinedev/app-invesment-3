@extends('member.layouts.app')
@section('content')
    <!-- Scrollable Content Area -->
    <div class="scrollable-content">
        <div class="content-section">
            <!-- Tab Navigation -->
            <div class="tab-navigation">
                <button class="tab-btn active" data-tab="digital">Digital Currency</button>
                <button class="tab-btn" data-tab="forex">Forex</button>
                <button class="tab-btn" data-tab="precious">Precious Metals</button>
            </div>

            @if ($announcement && !empty($announcement))
                <!-- Announcement Card -->
                <div class="card-dark shadow-sm p-3 mb-3 mt-3">
                    <div class="d-flex align-items-start gap-2">
                        <i class="bi bi-megaphone-fill text-gold" style="font-size: 18px; margin-top: 2px;"></i>
                        <div>
                            <h6 class="text-white mb-1" style="font-size: 13px;">Pengumuman</h6>
                            <p class="small text-muted mb-0" style="font-size: 12px;">
                                {{ $announcement }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Hot Section Card - Top 4 Crypto -->
            <div class="card-dark shadow-sm p-3 mb-3 mt-3"
                style="background: linear-gradient(135deg, rgba(169, 126, 0, 0.15) 0%, rgba(169, 126, 0, 0.05) 100%); border: 2px solid rgba(169, 126, 0, 0.3);">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="text-gold mb-0 fw-bold" style="font-size: 18px;">
                        <i class="bi bi-fire me-2"></i>Hot
                    </h5>
                </div>

                <!-- Hot Coins Grid -->
                <div class="row g-2">
                    @php
                        $hotCoins = array_slice($coinsByCategory['crypto'], 0, 4);
                    @endphp

                    @foreach ($hotCoins as $coin)
                        @php
                            $priceData = $allPrices[$coin['symbol']] ?? [
                                'price' => '0.00',
                                'change' => '0.00',
                                'isPositive' => true,
                            ];
                        @endphp
                        <div class="col-6">
                            <div class="card-dark p-3" style="background: #FFFFFF; border: 1px solid var(--border-color);">
                                <div class="mb-2">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <span class="fw-bold"
                                            style="font-size: 13px; color: var(--text-primary);">{{ $coin['symbol'] }}</span>
                                        <div class="coin-icon"
                                            style="width: 24px; height: 24px; background: {{ $coin['color'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="{{ $coin['icon'] }}" style="font-size: 14px; color: white;"></i>
                                        </div>
                                    </div>
                                    <div class="fw-bold coin-price" style="font-size: 16px; color: var(--text-primary);"
                                        data-symbol="{{ $coin['symbol'] }}">
                                        ${{ $priceData['price'] }}
                                    </div>
                                    <small class="price-change {{ $priceData['isPositive'] ? 'positive' : 'negative' }}"
                                        style="font-size: 11px;" data-symbol="{{ $coin['symbol'] }}">
                                        @if ($priceData['isPositive'])
                                            <i class="bi bi-arrow-up"></i>
                                        @else
                                            <i class="bi bi-arrow-down"></i>
                                        @endif
                                        {{ $priceData['change'] }}%
                                    </small>
                                </div>
                                <!-- Mini Chart -->
                                <div class="mini-chart {{ $priceData['isPositive'] ? 'positive' : 'negative' }}"
                                    data-symbol="{{ $coin['symbol'] }}">
                                    <canvas class="coin-chart" id="chart-{{ strtolower($coin['symbol']) }}"
                                        height="60"></canvas>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- All Markets Section -->
            <div class="mb-4 mt-3">
                <!-- Digital Currency Section -->
                <div class="market-section" id="section-digital" data-category="digital">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-3">
                        <h6 class="mb-0 fw-bold" style="color: var(--text-primary); font-size: 15px;">
                            Cryptocurrency
                        </h6>
                    </div>

                    <!-- Crypto Cards Grid (3 columns) -->
                    <div class="coin-cards-grid crypto-grid">
                        @foreach ($coinsByCategory['crypto'] as $coin)
                            @php
                                $priceData = $allPrices[$coin['symbol']] ?? [
                                    'price' => '0.00',
                                    'change' => '0.00',
                                    'isPositive' => true,
                                ];
                            @endphp
                            <div class="coin-card" data-symbol="{{ $coin['symbol'] }}">
                                <div class="coin-card-header">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">
                                            {{ $coin['symbol'] }}
                                        </div>
                                        <div class="coin-icon-small"
                                            style="width: 20px; height: 20px; background: {{ $coin['color'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="{{ $coin['icon'] }}" style="font-size: 11px; color: white;"></i>
                                        </div>
                                    </div>
                                    <div class="fw-bold coin-price"
                                        style="font-size: 16px; color: var(--text-primary); margin: 4px 0;"
                                        data-symbol="{{ $coin['symbol'] }}">
                                        ${{ $priceData['price'] }}
                                    </div>
                                    <small
                                        class="price-change-mini {{ $priceData['isPositive'] ? 'positive' : 'negative' }}"
                                        style="font-size: 11px;" data-symbol="{{ $coin['symbol'] }}">
                                        @if ($priceData['isPositive'])
                                            <i class="bi bi-arrow-up"></i>
                                        @else
                                            <i class="bi bi-arrow-down"></i>
                                        @endif
                                        {{ $priceData['change'] }}%
                                    </small>
                                </div>
                                <div class="coin-mini-chart {{ $priceData['isPositive'] ? 'positive' : 'negative' }}">
                                    <canvas class="coin-chart-small" id="chart-small-{{ strtolower($coin['symbol']) }}"
                                        height="70"></canvas>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Forex Section -->
                <div class="market-section" id="section-forex" data-category="forex">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-3">
                        <h6 class="mb-0 fw-bold" style="color: var(--text-primary); font-size: 15px;">
                            Forex
                        </h6>
                    </div>

                    <!-- Forex Cards Grid (2 columns) -->
                    <div class="coin-cards-grid forex-grid">
                        @foreach ($coinsByCategory['forex'] as $coin)
                            @php
                                $priceData = $allPrices[$coin['symbol']] ?? [
                                    'price' => '0.00',
                                    'change' => '0.00',
                                    'isPositive' => true,
                                ];
                            @endphp
                            <div class="coin-card" data-symbol="{{ $coin['symbol'] }}">
                                <div class="coin-card-header">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">
                                            {{ $coin['symbol'] }}
                                        </div>
                                        <div class="coin-icon-small"
                                            style="width: 20px; height: 20px; background: {{ $coin['color'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="{{ $coin['icon'] }}" style="font-size: 11px; color: white;"></i>
                                        </div>
                                    </div>
                                    <div class="fw-bold coin-price"
                                        style="font-size: 16px; color: var(--text-primary); margin: 4px 0;"
                                        data-symbol="{{ $coin['symbol'] }}">
                                        ${{ $priceData['price'] }}
                                    </div>
                                    <small
                                        class="price-change-mini {{ $priceData['isPositive'] ? 'positive' : 'negative' }}"
                                        style="font-size: 11px;" data-symbol="{{ $coin['symbol'] }}">
                                        @if ($priceData['isPositive'])
                                            <i class="bi bi-arrow-up"></i>
                                        @else
                                            <i class="bi bi-arrow-down"></i>
                                        @endif
                                        {{ $priceData['change'] }}%
                                    </small>
                                </div>
                                <div class="coin-mini-chart {{ $priceData['isPositive'] ? 'positive' : 'negative' }}">
                                    <canvas class="coin-chart-small" id="chart-small-{{ strtolower($coin['symbol']) }}"
                                        height="70"></canvas>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Precious Metals Section -->
                <div class="market-section" id="section-precious" data-category="precious">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-3">
                        <h6 class="mb-0 fw-bold" style="color: var(--text-primary); font-size: 15px;">
                            Precious Metals
                        </h6>
                    </div>

                    <!-- Precious Metals Cards Grid (2 columns) -->
                    <div class="coin-cards-grid forex-grid">
                        @foreach ($coinsByCategory['precious'] as $coin)
                            @php
                                $priceData = $allPrices[$coin['symbol']] ?? [
                                    'price' => '0.00',
                                    'change' => '0.00',
                                    'isPositive' => true,
                                ];
                            @endphp
                            <div class="coin-card" data-symbol="{{ $coin['symbol'] }}">
                                <div class="coin-card-header">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <div class="fw-bold" style="font-size: 12px; color: var(--text-primary);">
                                            {{ $coin['symbol'] }}
                                        </div>
                                        <div class="coin-icon-small"
                                            style="width: 20px; height: 20px; background: {{ $coin['color'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="{{ $coin['icon'] }}" style="font-size: 11px; color: white;"></i>
                                        </div>
                                    </div>
                                    <div class="fw-bold coin-price"
                                        style="font-size: 16px; color: var(--text-primary); margin: 4px 0;"
                                        data-symbol="{{ $coin['symbol'] }}">
                                        ${{ $priceData['price'] }}
                                    </div>
                                    <small
                                        class="price-change-mini {{ $priceData['isPositive'] ? 'positive' : 'negative' }}"
                                        style="font-size: 11px;" data-symbol="{{ $coin['symbol'] }}">
                                        @if ($priceData['isPositive'])
                                            <i class="bi bi-arrow-up"></i>
                                        @else
                                            <i class="bi bi-arrow-down"></i>
                                        @endif
                                        {{ $priceData['change'] }}%
                                    </small>
                                </div>
                                <div class="coin-mini-chart {{ $priceData['isPositive'] ? 'positive' : 'negative' }}">
                                    <canvas class="coin-chart-small" id="chart-small-{{ strtolower($coin['symbol']) }}"
                                        height="70"></canvas>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <style>
            .mini-chart {
                border-radius: 6px;
                overflow: hidden;
                background: rgba(0, 0, 0, 0.02);
                position: relative;
            }

            .mini-chart canvas {
                display: block;
                width: 100% !important;
            }

            .price-change {
                display: inline-flex;
                align-items: center;
                gap: 2px;
                transition: all 0.3s ease;
            }

            .price-change.positive {
                color: #22c55e;
            }

            .price-change.negative {
                color: #ef4444;
            }

            /* Coin Cards Grid - Default 3 columns for Crypto */
            .coin-cards-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
                padding: 0 16px;
            }

            /* Forex & Precious Metals - 2 columns */
            .coin-cards-grid.forex-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .coin-card {
                background: #FFFFFF;
                border: 1px solid var(--border-color);
                border-radius: 12px;
                padding: 12px;
                transition: all 0.2s ease;
                cursor: pointer;
            }

            .coin-card:hover {
                box-shadow: 0 4px 12px rgba(169, 126, 0, 0.1);
                border-color: rgba(169, 126, 0, 0.3);
                transform: translateY(-2px);
            }

            .coin-card-header {
                margin-bottom: 8px;
            }

            .coin-mini-chart {
                border-radius: 6px;
                overflow: hidden;
                background: rgba(0, 0, 0, 0.01);
                margin-top: 8px;
            }

            .price-change-mini {
                display: inline-flex;
                align-items: center;
                gap: 3px;
                font-weight: 600;
                transition: all 0.3s ease;
            }

            .price-change-mini.positive {
                color: #22c55e;
            }

            .price-change-mini.negative {
                color: #ef4444;
            }

            /* Market Section */
            .market-section {
                margin-bottom: 20px;
            }

            /* Price update animation */
            @keyframes priceUpdate {
                0% {
                    background: rgba(169, 126, 0, 0.2);
                }

                100% {
                    background: transparent;
                }
            }

            .price-updated {
                animation: priceUpdate 0.5s ease;
            }

            /* Loading skeleton */
            .skeleton {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200% 100%;
                animation: loading 1.5s infinite;
            }

            @keyframes loading {
                0% {
                    background-position: 200% 0;
                }

                100% {
                    background-position: -200% 0;
                }
            }

            /* Responsive - 2 columns for smaller screens */
            @media (max-width: 375px) {
                .coin-cards-grid {
                    grid-template-columns: repeat(2, 1fr);
                    gap: 8px;
                    padding: 0 12px;
                }

                .coin-card {
                    padding: 10px;
                }
            }

            /* Responsive - 2 columns for medium screens */
            @media (min-width: 376px) and (max-width: 480px) {
                .coin-cards-grid.crypto-grid {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
        </style>
    @endpush

    @push('scripts')
        <!-- Chart.js CDN -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

        <script>
            // ============================================
            // CRYPTOCURRENCY DASHBOARD - REAL-TIME CHARTS
            // ============================================

            // Store chart instances globally
            const chartInstances = {};

            // Configuration
            const CONFIG = {
                updateInterval: 10000, // Update every 10 seconds
                chartPoints: 20, // Number of data points in chart
                priceRoute: '{{ route('member.dashboard.prices') }}',
                csrfToken: '{{ csrf_token() }}'
            };

            // ============================================
            // INITIALIZATION
            // ============================================

            document.addEventListener('DOMContentLoaded', function() {
                console.log('🚀 Initializing Crypto Dashboard...');

                initializeAllCharts();
                startPriceUpdates();
                initializeTabNavigation();

                console.log('✅ Dashboard initialized successfully!');
            });

            // ============================================
            // CHART FUNCTIONS
            // ============================================

            /**
             * Initialize all charts on page load
             */
            function initializeAllCharts() {
                const canvases = document.querySelectorAll('canvas.coin-chart, canvas.coin-chart-small');

                console.log(`📊 Initializing ${canvases.length} charts...`);

                canvases.forEach(canvas => {
                    const symbol = canvas.closest('[data-symbol]')?.getAttribute('data-symbol');
                    if (symbol) {
                        initializeChart(canvas, symbol);
                    }
                });
            }

            /**
             * Initialize a single chart
             */
            function initializeChart(canvas, symbol) {
                const ctx = canvas.getContext('2d');
                const container = canvas.closest('.mini-chart, .coin-mini-chart');
                const isPositive = container?.classList.contains('positive') ?? true;

                // Generate initial data
                const data = generateChartData(isPositive);

                const chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            data: data.values,
                            borderColor: isPositive ? '#22c55e' : '#ef4444',
                            backgroundColor: isPositive ?
                                'rgba(34, 197, 94, 0.1)' :
                                'rgba(239, 68, 68, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointRadius: 0,
                            pointHoverRadius: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        animation: {
                            duration: 750,
                            easing: 'easeInOutQuart'
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                enabled: false
                            }
                        },
                        scales: {
                            x: {
                                display: false
                            },
                            y: {
                                display: false
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });

                // Store chart instance with canvas ID
                chartInstances[canvas.id] = {
                    chart: chart,
                    symbol: symbol,
                    canvas: canvas
                };
            }

            /**
             * Generate chart data
             */
            function generateChartData(isPositive = true) {
                const points = CONFIG.chartPoints;
                const labels = [];
                const values = [];
                let baseValue = 100;

                for (let i = 0; i < points; i++) {
                    labels.push('');

                    // Generate trend with some randomness
                    const change = (Math.random() - 0.5) * 5;
                    const trend = isPositive ? 0.5 : -0.5;
                    baseValue += change + trend;

                    values.push(Math.max(baseValue, 0));
                }

                return {
                    labels,
                    values
                };
            }

            /**
             * Update chart with new data
             */
            function updateChart(chartId, isPositive) {
                const chartData = chartInstances[chartId];
                if (!chartData) return;

                const chart = chartData.chart;
                const newData = generateChartData(isPositive);

                // Update colors
                chart.data.datasets[0].borderColor = isPositive ? '#22c55e' : '#ef4444';
                chart.data.datasets[0].backgroundColor = isPositive ?
                    'rgba(34, 197, 94, 0.1)' :
                    'rgba(239, 68, 68, 0.1)';

                // Update data
                chart.data.labels = newData.labels;
                chart.data.datasets[0].data = newData.values;

                // Update without animation for smooth transitions
                chart.update('none');
            }

            // ============================================
            // PRICE UPDATE FUNCTIONS
            // ============================================

            /**
             * Start real-time price updates
             */
            function startPriceUpdates() {
                // Get all unique symbols
                const symbols = getUniqueSymbols();

                console.log(`💰 Starting price updates for ${symbols.length} symbols...`);

                // Update prices immediately
                updatePrices(symbols);

                // Then update every X seconds
                setInterval(() => {
                    updatePrices(symbols);
                }, CONFIG.updateInterval);
            }

            /**
             * Get unique symbols from the page
             */
            function getUniqueSymbols() {
                const symbols = Array.from(document.querySelectorAll('[data-symbol]'))
                    .map(el => el.getAttribute('data-symbol'))
                    .filter((value, index, self) => self.indexOf(value) === index);

                return symbols;
            }

            /**
             * Fetch and update prices
             */
            async function updatePrices(symbols) {
                try {
                    const response = await fetch(CONFIG.priceRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': CONFIG.csrfToken
                        },
                        body: JSON.stringify({
                            symbols
                        })
                    });

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const result = await response.json();

                    if (result.success && result.data) {
                        Object.entries(result.data).forEach(([symbol, data]) => {
                            updatePriceDisplay(symbol, data);
                        });
                    }
                } catch (error) {
                    console.error('❌ Failed to update prices:', error);
                }
            }

            /**
             * Update price display for a symbol
             */
            function updatePriceDisplay(symbol, data) {
                // Update all price elements for this symbol
                const priceElements = document.querySelectorAll(`.coin-price[data-symbol="${symbol}"]`);
                const changeElements = document.querySelectorAll(
                    `.price-change[data-symbol="${symbol}"], .price-change-mini[data-symbol="${symbol}"]`
                );

                // Update prices
                priceElements.forEach(el => {
                    // Add animation
                    el.classList.add('price-updated');
                    setTimeout(() => el.classList.remove('price-updated'), 500);

                    // Update text
                    el.textContent = '$' + data.price;
                });

                // Update change percentages
                changeElements.forEach(el => {
                    const isPositive = data.isPositive;

                    // Update classes
                    el.classList.remove('positive', 'negative');
                    el.classList.add(isPositive ? 'positive' : 'negative');

                    // Update content
                    const icon = isPositive ? 'bi-arrow-up' : 'bi-arrow-down';
                    el.innerHTML = `<i class="bi ${icon}"></i> ${data.change}%`;
                });

                // Update all charts for this symbol
                updateChartsForSymbol(symbol, data.isPositive);

                // Update chart container classes
                const miniCharts = document.querySelectorAll(
                    `[data-symbol="${symbol}"] .mini-chart, [data-symbol="${symbol}"] .coin-mini-chart`
                );
                miniCharts.forEach(chart => {
                    chart.classList.remove('positive', 'negative');
                    chart.classList.add(data.isPositive ? 'positive' : 'negative');
                });
            }

            /**
             * Update all charts for a specific symbol
             */
            function updateChartsForSymbol(symbol, isPositive) {
                Object.entries(chartInstances).forEach(([chartId, chartData]) => {
                    if (chartData.symbol === symbol) {
                        updateChart(chartId, isPositive);
                    }
                });
            }

            // ============================================
            // TAB NAVIGATION
            // ============================================

            /**
             * Initialize tab navigation with smooth scroll
             */
            function initializeTabNavigation() {
                const tabButtons = document.querySelectorAll('.tab-btn');

                tabButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const targetTab = this.getAttribute('data-tab');

                        // Remove active class from all buttons
                        tabButtons.forEach(btn => btn.classList.remove('active'));

                        // Add active class to clicked button
                        this.classList.add('active');

                        // Scroll to target section
                        const targetSection = document.getElementById(`section-${targetTab}`);
                        if (targetSection) {
                            targetSection.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });

                // Update active tab on scroll
                observeMarketSections(tabButtons);
            }

            /**
             * Observe market sections for scroll-based tab updates
             */
            function observeMarketSections(tabButtons) {
                const observerOptions = {
                    root: null,
                    rootMargin: '-100px 0px -60% 0px',
                    threshold: 0
                };

                const observerCallback = (entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const category = entry.target.getAttribute('data-category');
                            tabButtons.forEach(btn => {
                                if (btn.getAttribute('data-tab') === category) {
                                    tabButtons.forEach(b => b.classList.remove('active'));
                                    btn.classList.add('active');
                                }
                            });
                        }
                    });
                };

                const observer = new IntersectionObserver(observerCallback, observerOptions);

                document.querySelectorAll('.market-section').forEach(section => {
                    observer.observe(section);
                });
            }

            // ============================================
            // UTILITY FUNCTIONS
            // ============================================

            /**
             * Show toast notification
             */
            function showToast(message, type = 'success') {
                const bgColor = type === 'success' ? '#22c55e' : '#ef4444';
                const toast = document.createElement('div');
                toast.style.cssText = `
                    position: fixed; 
                    top: 20px; 
                    right: 20px; 
                    background: ${bgColor}; 
                    color: white; 
                    padding: 12px 20px; 
                    border-radius: 8px; 
                    z-index: 9999; 
                    font-size: 14px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                `;
                toast.textContent = message;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }

            /**
             * Format number as currency
             */
            function formatCurrency(value, decimals = 2) {
                return new Intl.NumberFormat('en-US', {
                    style: 'currency',
                    currency: 'USD',
                    minimumFractionDigits: decimals,
                    maximumFractionDigits: decimals
                }).format(value);
            }

            /**
             * Format percentage
             */
            function formatPercentage(value, decimals = 2) {
                const sign = value >= 0 ? '+' : '';
                return sign + value.toFixed(decimals) + '%';
            }

            // ============================================
            // DEBUG FUNCTIONS (untuk development)
            // ============================================

            // Expose functions to window for debugging
            if (typeof window !== 'undefined') {
                window.cryptoDashboard = {
                    charts: chartInstances,
                    config: CONFIG,
                    updatePrices: updatePrices,
                    getSymbols: getUniqueSymbols,
                    showToast: showToast
                };

                console.log('💡 Debug: Access dashboard via window.cryptoDashboard');
            }
        </script>
    @endpush
@endsection
