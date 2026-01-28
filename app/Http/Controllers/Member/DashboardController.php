<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Config;
use App\Models\Transaction;
use App\Models\TradingSignal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $user = User::current();
        $announcement = Config::get('app_announcement')['value'] ?? null;
        $userBalance = Transaction::getUserBalance(auth()->id());

        // Generate referral link
        $referralLink = route('register', ['ref' => $user->refferal_code]);

        // Get available coins from model
        $availableCoins = TradingSignal::getAvailableCoins();

        // Group coins by category
        $coinsByCategory = [
            'crypto' => [],
            'forex' => [],
            'precious' => []
        ];

        foreach ($availableCoins as $symbol => $coinInfo) {
            // Categorize based on symbol pattern
            if (strpos($symbol, 'USDT') !== false && !in_array($symbol, ['EURUSDT', 'GBPUSDT', 'AUDUSDT', 'NZDUSDT', 'BRLUSDT', 'TRYUSDT'])) {
                $coinsByCategory['crypto'][] = array_merge(['symbol' => $symbol], $coinInfo);
            } elseif (strpos($symbol, 'USD') !== false || strpos($symbol, 'USDT') !== false) {
                $coinsByCategory['forex'][] = array_merge(['symbol' => $symbol], $coinInfo);
            } elseif (in_array($symbol, ['XAGUSD', 'XAUUSD', 'XPTUSD'])) {
                $coinsByCategory['precious'][] = array_merge(['symbol' => $symbol], $coinInfo);
            }
        }

        // Get real-time prices for all coins
        $allPrices = $this->getAllCoinPrices(array_keys($availableCoins));

        return view('member.pages.dashboard.index', compact(
            'user',
            'announcement',
            'userBalance',
            'referralLink',
            'coinsByCategory',
            'allPrices',
            'availableCoins'
        ));
    }

    /**
     * Get real-time prices for all coins
     */
    private function getAllCoinPrices($symbols)
    {
        $prices = [];

        foreach ($symbols as $symbol) {
            // Check if it's a crypto (Binance)
            if (strpos($symbol, 'USDT') !== false && !in_array($symbol, ['EURUSDT', 'GBPUSDT', 'AUDUSDT', 'NZDUSDT', 'BRLUSDT', 'TRYUSDT'])) {
                $prices[$symbol] = $this->getBinancePrice($symbol);
            }
            // Forex or precious metals (use forex API or fallback)
            else {
                $prices[$symbol] = $this->getForexPrice($symbol);
            }
        }

        return $prices;
    }

    /**
     * Get price from Binance for cryptocurrencies
     */
    private function getBinancePrice($symbol)
    {
        try {
            // Cache for 10 seconds to avoid too many API calls
            return Cache::remember("binance_price_{$symbol}", 10, function () use ($symbol) {
                $response = Http::timeout(5)->get('https://api.binance.com/api/v3/ticker/24hr', [
                    'symbol' => $symbol
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'price' => number_format((float)$data['lastPrice'], 2, '.', ''),
                        'change' => number_format((float)$data['priceChangePercent'], 2, '.', ''),
                        'isPositive' => (float)$data['priceChangePercent'] >= 0,
                        'high' => (float)$data['highPrice'],
                        'low' => (float)$data['lowPrice'],
                        'volume' => (float)$data['volume']
                    ];
                }

                throw new \Exception('Binance API failed');
            });
        } catch (\Exception $e) {
            Log::warning("Failed to fetch Binance price for {$symbol}: " . $e->getMessage());
            return $this->getFallbackPrice($symbol);
        }
    }

    /**
     * Get price for forex and precious metals
     */
    private function getForexPrice($symbol)
    {
        try {
            // Cache for 30 seconds
            return Cache::remember("forex_price_{$symbol}", 30, function () use ($symbol) {
                // You can use Alpha Vantage, Twelve Data, or other forex API
                // For now, using a simplified approach

                // Convert symbol format (e.g., EURUSDT -> EUR/USD)
                $pair = $this->formatForexPair($symbol);

                // Example using exchangerate-api.com (free tier available)
                $response = Http::timeout(5)->get("https://api.exchangerate-api.com/v4/latest/USD");

                if ($response->successful()) {
                    $data = $response->json();
                    $rate = $this->calculateForexRate($symbol, $data['rates']);

                    return [
                        'price' => number_format($rate['price'], 4, '.', ''),
                        'change' => number_format($rate['change'], 2, '.', ''),
                        'isPositive' => $rate['change'] >= 0,
                        'high' => $rate['price'] * 1.002,
                        'low' => $rate['price'] * 0.998,
                        'volume' => 0
                    ];
                }

                throw new \Exception('Forex API failed');
            });
        } catch (\Exception $e) {
            Log::warning("Failed to fetch forex price for {$symbol}: " . $e->getMessage());
            return $this->getFallbackPrice($symbol);
        }
    }

    /**
     * Format forex pair for API
     */
    private function formatForexPair($symbol)
    {
        // Remove USDT/USD suffix and format
        $symbol = str_replace(['USDT', 'USD'], '', $symbol);
        return $symbol . '/USD';
    }

    /**
     * Calculate forex rate from API data
     */
    private function calculateForexRate($symbol, $rates)
    {
        // Simplified calculation - you may need to adjust based on your needs
        $base = str_replace(['USDT', 'USD'], '', $symbol);

        if (isset($rates[$base])) {
            $price = 1 / $rates[$base];
            // Simulate daily change (you should use real historical data)
            $change = (rand(-100, 100) / 100);

            return [
                'price' => $price,
                'change' => $change
            ];
        }

        // Special handling for precious metals
        if ($symbol === 'XAUUSD') {
            return ['price' => 2043.67, 'change' => 0.87];
        } elseif ($symbol === 'XAGUSD') {
            return ['price' => 24.56, 'change' => 1.23];
        } elseif ($symbol === 'XPTUSD') {
            return ['price' => 934.21, 'change' => -0.45];
        }

        return ['price' => 1.0, 'change' => 0];
    }

    /**
     * Fallback prices when API fails
     */
    private function getFallbackPrice($symbol)
    {
        $fallbackPrices = [
            // Crypto
            'BTCUSDT' => ['price' => '43250.50', 'change' => '2.45', 'isPositive' => true],
            'ETHUSDT' => ['price' => '2914.66', 'change' => '1.87', 'isPositive' => true],
            'XRPUSDT' => ['price' => '0.5234', 'change' => '-0.92', 'isPositive' => false],
            'LINKUSDT' => ['price' => '14.23', 'change' => '3.12', 'isPositive' => true],
            'DOTUSDT' => ['price' => '7.89', 'change' => '1.23', 'isPositive' => true],
            'DOGEUSDT' => ['price' => '0.0812', 'change' => '-1.45', 'isPositive' => false],
            'BCHUSDT' => ['price' => '245.67', 'change' => '2.15', 'isPositive' => true],
            'FILUSDT' => ['price' => '5.42', 'change' => '-0.78', 'isPositive' => false],
            'LTCUSDT' => ['price' => '73.21', 'change' => '1.56', 'isPositive' => true],
            'ZECUSDT' => ['price' => '42.89', 'change' => '-2.34', 'isPositive' => false],
            'DASHUSDT' => ['price' => '31.56', 'change' => '0.89', 'isPositive' => true],

            // Forex
            'HKDUSD' => ['price' => '0.1283', 'change' => '0.12', 'isPositive' => true],
            'INRUSD' => ['price' => '0.0120', 'change' => '-0.08', 'isPositive' => false],
            'KRWUSD' => ['price' => '0.0007', 'change' => '0.15', 'isPositive' => true],
            'SGDUSD' => ['price' => '0.7456', 'change' => '0.21', 'isPositive' => true],
            'BRLUSDT' => ['price' => '0.1987', 'change' => '-0.34', 'isPositive' => false],
            'TRYUSDT' => ['price' => '0.0312', 'change' => '-0.56', 'isPositive' => false],
            'EURUSDT' => ['price' => '1.0856', 'change' => '0.18', 'isPositive' => true],
            'GBPUSDT' => ['price' => '1.2734', 'change' => '0.25', 'isPositive' => true],
            'AUDUSDT' => ['price' => '0.6734', 'change' => '0.32', 'isPositive' => true],
            'NZDUSDT' => ['price' => '0.6123', 'change' => '-0.19', 'isPositive' => false],

            // Precious Metals
            'XAGUSD' => ['price' => '24.56', 'change' => '1.23', 'isPositive' => true],
            'XAUUSD' => ['price' => '2043.67', 'change' => '0.87', 'isPositive' => true],
            'XPTUSD' => ['price' => '934.21', 'change' => '-0.45', 'isPositive' => false],
        ];

        return $fallbackPrices[$symbol] ?? [
            'price' => '0.00',
            'change' => '0.00',
            'isPositive' => true,
            'high' => 0,
            'low' => 0,
            'volume' => 0
        ];
    }

    /**
     * API endpoint untuk real-time price updates (AJAX)
     */
    public function getPrices(Request $request)
    {
        $symbols = $request->input('symbols', []);
        $prices = [];

        foreach ($symbols as $symbol) {
            if (strpos($symbol, 'USDT') !== false && !in_array($symbol, ['EURUSDT', 'GBPUSDT', 'AUDUSDT', 'NZDUSDT', 'BRLUSDT', 'TRYUSDT'])) {
                $prices[$symbol] = $this->getBinancePrice($symbol);
            } else {
                $prices[$symbol] = $this->getForexPrice($symbol);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $prices
        ]);
    }

    /**
     * Get historical data for charts (simplified - you may want to use a proper charting API)
     */
    public function getChartData(Request $request)
    {
        $symbol = $request->input('symbol');
        $interval = $request->input('interval', '1h'); // 1h, 4h, 1d

        try {
            if (strpos($symbol, 'USDT') !== false && !in_array($symbol, ['EURUSDT', 'GBPUSDT', 'AUDUSDT', 'NZDUSDT', 'BRLUSDT', 'TRYUSDT'])) {
                // Get from Binance
                $response = Http::timeout(5)->get('https://api.binance.com/api/v3/klines', [
                    'symbol' => $symbol,
                    'interval' => $interval,
                    'limit' => 24 // Last 24 data points
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    $chartData = array_map(function ($item) {
                        return [
                            'time' => $item[0],
                            'open' => (float)$item[1],
                            'high' => (float)$item[2],
                            'low' => (float)$item[3],
                            'close' => (float)$item[4],
                            'volume' => (float)$item[5]
                        ];
                    }, $data);

                    return response()->json([
                        'success' => true,
                        'data' => $chartData
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error("Failed to fetch chart data for {$symbol}: " . $e->getMessage());
        }

        // Fallback - generate random data for demo
        return response()->json([
            'success' => false,
            'message' => 'Using fallback data',
            'data' => $this->generateFallbackChartData()
        ]);
    }

    /**
     * Generate fallback chart data
     */
    private function generateFallbackChartData()
    {
        $data = [];
        $basePrice = 100;

        for ($i = 0; $i < 24; $i++) {
            $change = (rand(-200, 200) / 100);
            $basePrice += $change;

            $data[] = [
                'time' => time() - (24 - $i) * 3600,
                'close' => round($basePrice, 2),
                'high' => round($basePrice * 1.01, 2),
                'low' => round($basePrice * 0.99, 2),
            ];
        }

        return $data;
    }
}
