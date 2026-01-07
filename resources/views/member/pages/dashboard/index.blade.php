<!-- Card 3: Market Overview with Mini Charts -->
<div class="card-dark shadow-sm p-0 mb-3">
    <div class="p-3" style="border-bottom: 1px solid var(--border-color);">
        <div class="d-flex align-items-center justify-content-between">
            <h6 class="text-white mb-0">Market Overview</h6>
            <span class="market-status-badge active">
                <i class="bi bi-circle-fill me-1"></i>Live
            </span>
        </div>
    </div>

    <!-- BTC/USDT -->
    <div class="market-coin-item">
        <div class="tradingview-widget-container" style="height: 70px;">
            <div class="tradingview-widget-container__widget"></div>
        </div>
    </div>

    <!-- ETH/USDT -->
    <div class="market-coin-item">
        <div class="tradingview-widget-container" style="height: 70px;">
            <div class="tradingview-widget-container__widget"></div>
        </div>
    </div>

    <!-- Tambahkan untuk coin lainnya -->
</div>

<!-- Script untuk Multiple Mini Charts -->
<script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js"
    async>
    {
        "symbol": "BINANCE:BTCUSDT",
        "width": "100%",
        "height": "70",
        "locale": "en",
        "dateRange": "1D",
        "colorTheme": "dark",
        "isTransparent": true,
        "autosize": false,
        "largeChartUrl": ""
    }
</script>
