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
                            <div class="card-dark p-3" style="background: #FFFFFF; border: 1px solid #e5e7eb;">
                                <div class="mb-2">
                                    <div class="d-flex align-items-center justify-content-between mb-1">
                                        <span class="fw-bold"
                                            style="font-size: 13px; color: #1f2937;">{{ $coin['symbol'] }}</span>
                                        <div class="coin-icon"
                                            style="width: 24px; height: 24px; background: {{ $coin['color'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="{{ $coin['icon'] }}" style="font-size: 14px; color: white;"></i>
                                        </div>
                                    </div>
                                    <div class="fw-bold coin-price" style="font-size: 16px; color: #1f2937;"
                                        data-symbol="{{ $coin['symbol'] }}">
                                        ${{ $priceData['price'] }}
                                    </div>
                                    <small class="price-change {{ $priceData['isPositive'] ? 'positive' : 'negative' }}"
                                        data-symbol="{{ $coin['symbol'] }}">
                                        <i class="bi bi-arrow-{{ $priceData['isPositive'] ? 'up' : 'down' }}"></i>
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
                        <h6 class="mb-0 fw-bold" style="color: #1f2937; font-size: 15px;">Cryptocurrency</h6>
                    </div>

                    <!-- Crypto Cards Grid (3 columns compact) -->
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
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold"
                                        style="font-size: 11px; color: #1f2937;">{{ $coin['symbol'] }}</span>
                                    <div
                                        style="width: 18px; height: 18px; background: {{ $coin['color'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="{{ $coin['icon'] }}" style="font-size: 9px; color: white;"></i>
                                    </div>
                                </div>
                                <div class="fw-bold coin-price" style="font-size: 13px; color: #1f2937; margin: 2px 0;"
                                    data-symbol="{{ $coin['symbol'] }}">
                                    ${{ $priceData['price'] }}
                                </div>
                                <div class="price-change-mini {{ $priceData['isPositive'] ? 'positive' : 'negative' }}"
                                    data-symbol="{{ $coin['symbol'] }}">
                                    <i class="bi bi-arrow-{{ $priceData['isPositive'] ? 'up' : 'down' }}"></i>
                                    {{ $priceData['change'] }}%
                                </div>
                                <div class="coin-mini-chart {{ $priceData['isPositive'] ? 'positive' : 'negative' }}">
                                    <canvas class="coin-chart-small" id="chart-small-{{ strtolower($coin['symbol']) }}"
                                        height="45"></canvas>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Forex Section -->
                <div class="market-section" id="section-forex" data-category="forex">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-3">
                        <h6 class="mb-0 fw-bold" style="color: #1f2937; font-size: 15px;">Forex</h6>
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
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold"
                                        style="font-size: 11px; color: #1f2937;">{{ $coin['symbol'] }}</span>
                                    <div
                                        style="width: 18px; height: 18px; background: {{ $coin['color'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="{{ $coin['icon'] }}" style="font-size: 9px; color: white;"></i>
                                    </div>
                                </div>
                                <div class="fw-bold coin-price" style="font-size: 13px; color: #1f2937; margin: 2px 0;"
                                    data-symbol="{{ $coin['symbol'] }}">
                                    ${{ $priceData['price'] }}
                                </div>
                                <div class="price-change-mini {{ $priceData['isPositive'] ? 'positive' : 'negative' }}"
                                    data-symbol="{{ $coin['symbol'] }}">
                                    <i class="bi bi-arrow-{{ $priceData['isPositive'] ? 'up' : 'down' }}"></i>
                                    {{ $priceData['change'] }}%
                                </div>
                                <div class="coin-mini-chart {{ $priceData['isPositive'] ? 'positive' : 'negative' }}">
                                    <canvas class="coin-chart-small" id="chart-small-{{ strtolower($coin['symbol']) }}"
                                        height="45"></canvas>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Precious Metals Section -->
                <div class="market-section" id="section-precious" data-category="precious">
                    <div class="d-flex align-items-center justify-content-between mb-3 px-3">
                        <h6 class="mb-0 fw-bold" style="color: #1f2937; font-size: 15px;">Precious Metals</h6>
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
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <span class="fw-bold"
                                        style="font-size: 11px; color: #1f2937;">{{ $coin['symbol'] }}</span>
                                    <div
                                        style="width: 18px; height: 18px; background: {{ $coin['color'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="{{ $coin['icon'] }}" style="font-size: 9px; color: white;"></i>
                                    </div>
                                </div>
                                <div class="fw-bold coin-price" style="font-size: 13px; color: #1f2937; margin: 2px 0;"
                                    data-symbol="{{ $coin['symbol'] }}">
                                    ${{ $priceData['price'] }}
                                </div>
                                <div class="price-change-mini {{ $priceData['isPositive'] ? 'positive' : 'negative' }}"
                                    data-symbol="{{ $coin['symbol'] }}">
                                    <i class="bi bi-arrow-{{ $priceData['isPositive'] ? 'up' : 'down' }}"></i>
                                    {{ $priceData['change'] }}%
                                </div>
                                <div class="coin-mini-chart {{ $priceData['isPositive'] ? 'positive' : 'negative' }}">
                                    <canvas class="coin-chart-small" id="chart-small-{{ strtolower($coin['symbol']) }}"
                                        height="45"></canvas>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Hot Section Chart */
        .mini-chart {
            border-radius: 6px;
            overflow: hidden;
            background: rgba(0, 0, 0, 0.02);
        }

        .mini-chart canvas {
            display: block;
            width: 100% !important;
        }

        .price-change {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            font-size: 11px;
            font-weight: 600;
        }

        .price-change.positive {
            color: #22c55e;
        }

        .price-change.negative {
            color: #ef4444;
        }

        /* Compact Grid Layout */
        .coin-cards-grid {
            display: grid;
            gap: 8px;
            padding: 0 12px;
        }

        .crypto-grid {
            grid-template-columns: repeat(3, 1fr);
        }

        .forex-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .coin-card {
            background: #FFFFFF;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .coin-card:hover {
            box-shadow: 0 2px 8px rgba(169, 126, 0, 0.15);
            border-color: rgba(169, 126, 0, 0.4);
            transform: translateY(-1px);
        }

        .coin-mini-chart {
            border-radius: 4px;
            overflow: hidden;
            background: rgba(0, 0, 0, 0.01);
            margin-top: 6px;
            height: 45px;
        }

        .coin-mini-chart canvas {
            display: block;
            width: 100% !important;
            height: 45px !important;
        }

        .price-change-mini {
            display: inline-flex;
            align-items: center;
            gap: 2px;
            font-weight: 600;
            font-size: 9px;
        }

        .price-change-mini.positive {
            color: #22c55e;
        }

        .price-change-mini.negative {
            color: #ef4444;
        }

        .market-section {
            margin-bottom: 20px;
        }

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

        @media (max-width: 375px) {
            .crypto-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .coin-card {
                padding: 6px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        const chartInstances = {};
        let priceUpdateTimer = null;
        let isPageVisible = true;

        const CONFIG = {
            updateInterval: 10000,
            chartPoints: 20,
            priceRoute: '{{ route('member.dashboard.prices') }}',
            csrfToken: '{{ csrf_token() }}',
            batchSize: 10
        };

        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Dashboard initializing...');
            initializeVisibleChartsOnly();
            startPriceUpdates();
            initializeTabNavigation();
            setupVisibilityListener();
            setupIntersectionObserver();
        });

        function setupVisibilityListener() {
            document.addEventListener('visibilitychange', function() {
                isPageVisible = !document.hidden;
                isPageVisible ? startPriceUpdates() : stopPriceUpdates();
            });
        }

        function setupIntersectionObserver() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const canvas = entry.target;
                        const symbol = canvas.closest('[data-symbol]')?.getAttribute('data-symbol');
                        if (symbol && !chartInstances[canvas.id]) {
                            initializeChart(canvas, symbol);
                        }
                    }
                });
            }, {
                rootMargin: '50px'
            });

            document.querySelectorAll('canvas.coin-chart, canvas.coin-chart-small').forEach(canvas => {
                observer.observe(canvas);
            });
        }

        function stopPriceUpdates() {
            if (priceUpdateTimer) {
                clearInterval(priceUpdateTimer);
                priceUpdateTimer = null;
            }
        }

        function initializeVisibleChartsOnly() {
            const visibleCanvases = Array.from(
                document.querySelectorAll('canvas.coin-chart, canvas.coin-chart-small')
            ).filter(canvas => canvas.getBoundingClientRect().top < window.innerHeight + 100);

            console.log(`📊 Initializing ${visibleCanvases.length} visible charts`);
            processBatch(visibleCanvases, 0);
        }

        function processBatch(canvases, startIndex) {
            const batch = canvases.slice(startIndex, startIndex + CONFIG.batchSize);
            batch.forEach(canvas => {
                const symbol = canvas.closest('[data-symbol]')?.getAttribute('data-symbol');
                if (symbol) initializeChart(canvas, symbol);
            });

            if (startIndex + CONFIG.batchSize < canvases.length) {
                requestAnimationFrame(() => processBatch(canvases, startIndex + CONFIG.batchSize));
            }
        }

        function initializeChart(canvas, symbol) {
            if (chartInstances[canvas.id]) return;

            const ctx = canvas.getContext('2d');
            const container = canvas.closest('.mini-chart, .coin-mini-chart');
            const isPositive = container?.classList.contains('positive') ?? true;
            const data = generateChartData(isPositive);

            const chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        data: data.values,
                        borderColor: isPositive ? '#22c55e' : '#ef4444',
                        backgroundColor: isPositive ? 'rgba(34, 197, 94, 0.1)' : 'rgba(239, 68, 68, 0.1)',
                        borderWidth: 1.5,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: {
                        duration: 0
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
                    }
                }
            });

            chartInstances[canvas.id] = {
                chart,
                symbol,
                canvas
            };
        }

        function generateChartData(isPositive = true) {
            const labels = [],
                values = [];
            let baseValue = 100;
            for (let i = 0; i < CONFIG.chartPoints; i++) {
                labels.push('');
                baseValue += (Math.random() - 0.5) * 5 + (isPositive ? 0.5 : -0.5);
                values.push(Math.max(baseValue, 0));
            }
            return {
                labels,
                values
            };
        }

        function updateChart(chartId, isPositive) {
            const chartData = chartInstances[chartId];
            if (!chartData) return;

            const chart = chartData.chart;
            const newData = generateChartData(isPositive);

            chart.data.datasets[0].borderColor = isPositive ? '#22c55e' : '#ef4444';
            chart.data.datasets[0].backgroundColor = isPositive ? 'rgba(34, 197, 94, 0.1)' : 'rgba(239, 68, 68, 0.1)';
            chart.data.labels = newData.labels;
            chart.data.datasets[0].data = newData.values;
            chart.update('none');
        }

        function startPriceUpdates() {
            stopPriceUpdates();
            const symbols = getUniqueSymbols();
            console.log(`💰 Price updates started for ${symbols.length} symbols`);

            updatePrices(symbols);
            priceUpdateTimer = setInterval(() => {
                if (isPageVisible) updatePrices(symbols);
            }, CONFIG.updateInterval);
        }

        function getUniqueSymbols() {
            return [...new Set(Array.from(document.querySelectorAll('[data-symbol]'))
                .map(el => el.getAttribute('data-symbol')))];
        }

        async function updatePrices(symbols) {
            try {
                console.log('🔄 Fetching prices...');

                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 8000);

                const response = await fetch(CONFIG.priceRoute, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CONFIG.csrfToken
                    },
                    body: JSON.stringify({
                        symbols
                    }),
                    signal: controller.signal
                });

                clearTimeout(timeoutId);
                if (!response.ok) throw new Error(`HTTP ${response.status}`);

                const result = await response.json();
                console.log('✅ Prices fetched:', Object.keys(result.data || {}).length);

                if (result.success && result.data) {
                    requestAnimationFrame(() => {
                        Object.entries(result.data).forEach(([symbol, data]) => {
                            updatePriceDisplay(symbol, data);
                        });
                    });
                }
            } catch (error) {
                if (error.name !== 'AbortError') {
                    console.error('❌ Failed:', error.message);
                }
            }
        }

        function updatePriceDisplay(symbol, data) {
            document.querySelectorAll(`.coin-price[data-symbol="${symbol}"]`).forEach(el => {
                el.classList.add('price-updated');
                el.textContent = '$' + data.price;
                setTimeout(() => el.classList.remove('price-updated'), 500);
            });

            document.querySelectorAll(`.price-change[data-symbol="${symbol}"], .price-change-mini[data-symbol="${symbol}"]`)
                .forEach(el => {
                    el.classList.remove('positive', 'negative');
                    el.classList.add(data.isPositive ? 'positive' : 'negative');
                    el.innerHTML = `<i class="bi bi-arrow-${data.isPositive ? 'up' : 'down'}"></i> ${data.change}%`;
                });

            document.querySelectorAll(`[data-symbol="${symbol}"] .mini-chart, [data-symbol="${symbol}"] .coin-mini-chart`)
                .forEach(chart => {
                    chart.classList.remove('positive', 'negative');
                    chart.classList.add(data.isPositive ? 'positive' : 'negative');
                });

            updateChartsForSymbol(symbol, data.isPositive);
        }

        function updateChartsForSymbol(symbol, isPositive) {
            Object.entries(chartInstances).forEach(([chartId, chartData]) => {
                if (chartData.symbol === symbol) updateChart(chartId, isPositive);
            });
        }

        function initializeTabNavigation() {
            const tabButtons = document.querySelectorAll('.tab-btn');
            tabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetTab = this.getAttribute('data-tab');
                    tabButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const targetSection = document.getElementById(`section-${targetTab}`);
                    if (targetSection) {
                        targetSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            observeMarketSections(tabButtons);
        }

        function observeMarketSections(tabButtons) {
            const observer = new IntersectionObserver((entries) => {
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
            }, {
                rootMargin: '-100px 0px -60% 0px',
                threshold: 0
            });

            document.querySelectorAll('.market-section').forEach(section => observer.observe(section));
        }

        window.addEventListener('beforeunload', () => {
            stopPriceUpdates();
            Object.values(chartInstances).forEach(d => d.chart?.destroy());
        });
    </script>
@endpush
