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
        $coinsByCategory = $this->groupCoinsByCategory($availableCoins);

        // Return fallback prices only for initial render
        $allPrices = $this->getFallbackPricesOnly(array_keys($availableCoins));

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
     * Group coins by category
     */
    private function groupCoinsByCategory($availableCoins)
    {
        $coinsByCategory = [
            'crypto' => [],
            'forex' => [],
            'precious' => []
        ];

        foreach ($availableCoins as $symbol => $coinInfo) {
            $coinData = array_merge(['symbol' => $symbol], $coinInfo);

            // Check precious metals first
            if (in_array($symbol, ['XAGUSD', 'XAUUSD', 'XPTUSD'])) {
                $coinsByCategory['precious'][] = $coinData;
            }
            // Then check crypto (USDT pairs excluding fiat pairs)
            elseif (strpos($symbol, 'USDT') !== false && !in_array($symbol, ['EURUSDT', 'GBPUSDT', 'AUDUSDT', 'NZDUSDT', 'BRLUSDT', 'TRYUSDT'])) {
                $coinsByCategory['crypto'][] = $coinData;
            }
            // Remaining are forex
            else {
                $coinsByCategory['forex'][] = $coinData;
            }
        }

        return $coinsByCategory;
    }

    /**
     * Return fallback prices for initial render
     */
    private function getFallbackPricesOnly($symbols)
    {
        $fallbackPrices = $this->getAllFallbackPrices();
        $prices = [];

        foreach ($symbols as $symbol) {
            $prices[$symbol] = $fallbackPrices[$symbol] ?? [
                'price' => '0.00',
                'change' => '0.00',
                'isPositive' => true,
                'high' => 0,
                'low' => 0,
                'volume' => 0
            ];
        }

        return $prices;
    }

    /**
     * API endpoint for real-time price updates (AJAX)
     */
    public function getPrices(Request $request)
    {
        $symbols = $request->input('symbols', []);

        // Batch fetch prices
        $prices = $this->getAllCoinPricesBatch($symbols);

        return response()->json([
            'success' => true,
            'data' => $prices
        ]);
    }

    /**
     * Batch fetch prices for multiple symbols
     */
    private function getAllCoinPricesBatch($symbols)
    {
        $prices = [];

        // Separate crypto and non-crypto
        $cryptoSymbols = [];
        $forexSymbols = [];

        foreach ($symbols as $symbol) {
            if (strpos($symbol, 'USDT') !== false && !in_array($symbol, ['EURUSDT', 'GBPUSDT', 'AUDUSDT', 'NZDUSDT', 'BRLUSDT', 'TRYUSDT'])) {
                $cryptoSymbols[] = $symbol;
            } else {
                $forexSymbols[] = $symbol;
            }
        }

        // Batch fetch crypto prices
        if (!empty($cryptoSymbols)) {
            $cryptoPrices = $this->getBinancePricesBatch($cryptoSymbols);
            $prices = array_merge($prices, $cryptoPrices);
        }

        // Batch fetch forex prices
        if (!empty($forexSymbols)) {
            $forexPrices = $this->getForexPricesBatch($forexSymbols);
            $prices = array_merge($prices, $forexPrices);
        }

        return $prices;
    }

    /**
     * Batch fetch from Binance
     */
    private function getBinancePricesBatch($symbols)
    {
        try {
            return Cache::remember('binance_prices_batch', 10, function () use ($symbols) {
                $prices = [];
                $response = Http::timeout(8)->get('https://api.binance.com/api/v3/ticker/24hr');

                if ($response->successful()) {
                    $allTickers = $response->json();

                    foreach ($allTickers as $ticker) {
                        if (in_array($ticker['symbol'], $symbols)) {
                            $lastPrice = (float)$ticker['lastPrice'];

                            // Format based on price range
                            if ($lastPrice < 1) {
                                $formattedPrice = number_format($lastPrice, 4, '.', '');
                            } elseif ($lastPrice < 100) {
                                $formattedPrice = number_format($lastPrice, 2, '.', '');
                            } else {
                                $formattedPrice = number_format($lastPrice, 2, '.', ',');
                            }

                            $prices[$ticker['symbol']] = [
                                'price' => $formattedPrice,
                                'change' => number_format((float)$ticker['priceChangePercent'], 2, '.', ''),
                                'isPositive' => (float)$ticker['priceChangePercent'] >= 0,
                                'high' => (float)$ticker['highPrice'],
                                'low' => (float)$ticker['lowPrice'],
                                'volume' => (float)$ticker['volume']
                            ];
                        }
                    }

                    return $prices;
                }

                throw new \Exception('Binance API failed');
            });
        } catch (\Exception $e) {
            Log::warning("Binance batch fetch failed: " . $e->getMessage());
            return $this->getFallbackPricesForSymbols($symbols);
        }
    }

    /**
     * Batch fetch forex prices
     */
    private function getForexPricesBatch($symbols)
    {
        try {
            return Cache::remember('forex_prices_batch', 30, function () use ($symbols) {
                $prices = [];
                $response = Http::timeout(8)->get("https://api.exchangerate-api.com/v4/latest/USD");

                if ($response->successful()) {
                    $data = $response->json();

                    foreach ($symbols as $symbol) {
                        $rate = $this->calculateForexRate($symbol, $data['rates']);

                        $prices[$symbol] = [
                            'price' => number_format($rate['price'], 4, '.', ''),
                            'change' => number_format($rate['change'], 2, '.', ''),
                            'isPositive' => $rate['change'] >= 0,
                            'high' => $rate['price'] * 1.002,
                            'low' => $rate['price'] * 0.998,
                            'volume' => 0
                        ];
                    }

                    return $prices;
                }

                throw new \Exception('Forex API failed');
            });
        } catch (\Exception $e) {
            Log::warning("Forex batch fetch failed: " . $e->getMessage());
            return $this->getFallbackPricesForSymbols($symbols);
        }
    }

    /**
     * Calculate forex rate from API data
     */
    private function calculateForexRate($symbol, $rates)
    {
        $base = str_replace(['USDT', 'USD'], '', $symbol);

        if (isset($rates[$base])) {
            $price = 1 / $rates[$base];
            $change = (rand(-100, 100) / 100);

            return ['price' => $price, 'change' => $change];
        }

        // Special handling for precious metals
        if ($symbol === 'XAUUSD') return ['price' => 2043.67, 'change' => 0.87];
        if ($symbol === 'XAGUSD') return ['price' => 24.56, 'change' => 1.23];
        if ($symbol === 'XPTUSD') return ['price' => 934.21, 'change' => -0.45];

        return ['price' => 1.0, 'change' => 0];
    }

    /**
     * Get fallback prices for specific symbols
     */
    private function getFallbackPricesForSymbols($symbols)
    {
        $allFallbacks = $this->getAllFallbackPrices();
        $result = [];

        foreach ($symbols as $symbol) {
            $result[$symbol] = $allFallbacks[$symbol] ?? [
                'price' => '0.00',
                'change' => '0.00',
                'isPositive' => true,
                'high' => 0,
                'low' => 0,
                'volume' => 0
            ];
        }

        return $result;
    }

    /**
     * All fallback prices
     */
    private function getAllFallbackPrices()
    {
        return [
            // Crypto
            'BTCUSDT' => ['price' => '43250.50', 'change' => '2.45', 'isPositive' => true, 'high' => 43500, 'low' => 42800, 'volume' => 15000],
            'ETHUSDT' => ['price' => '2914.66', 'change' => '1.87', 'isPositive' => true, 'high' => 2950, 'low' => 2880, 'volume' => 8000],
            'XRPUSDT' => ['price' => '0.5234', 'change' => '-0.92', 'isPositive' => false, 'high' => 0.53, 'low' => 0.52, 'volume' => 50000],
            'LINKUSDT' => ['price' => '14.23', 'change' => '3.12', 'isPositive' => true, 'high' => 14.5, 'low' => 13.8, 'volume' => 2000],
            'DOTUSDT' => ['price' => '7.89', 'change' => '1.23', 'isPositive' => true, 'high' => 8.0, 'low' => 7.7, 'volume' => 3000],
            'DOGEUSDT' => ['price' => '0.0812', 'change' => '-1.45', 'isPositive' => false, 'high' => 0.083, 'low' => 0.080, 'volume' => 100000],
            'BCHUSDT' => ['price' => '245.67', 'change' => '2.15', 'isPositive' => true, 'high' => 248, 'low' => 242, 'volume' => 1200],
            'FILUSDT' => ['price' => '5.42', 'change' => '-0.78', 'isPositive' => false, 'high' => 5.5, 'low' => 5.3, 'volume' => 1500],
            'LTCUSDT' => ['price' => '73.21', 'change' => '1.56', 'isPositive' => true, 'high' => 74, 'low' => 72, 'volume' => 800],
            'ZECUSDT' => ['price' => '42.89', 'change' => '-2.34', 'isPositive' => false, 'high' => 44, 'low' => 42, 'volume' => 600],
            'DASHUSDT' => ['price' => '31.56', 'change' => '0.89', 'isPositive' => true, 'high' => 32, 'low' => 31, 'volume' => 400],

            // Forex
            'HKDUSD' => ['price' => '0.1283', 'change' => '0.12', 'isPositive' => true, 'high' => 0.129, 'low' => 0.128, 'volume' => 0],
            'INRUSD' => ['price' => '0.0120', 'change' => '-0.08', 'isPositive' => false, 'high' => 0.0121, 'low' => 0.0119, 'volume' => 0],
            'KRWUSD' => ['price' => '0.0007', 'change' => '0.15', 'isPositive' => true, 'high' => 0.00071, 'low' => 0.00069, 'volume' => 0],
            'SGDUSD' => ['price' => '0.7456', 'change' => '0.21', 'isPositive' => true, 'high' => 0.747, 'low' => 0.744, 'volume' => 0],
            'BRLUSDT' => ['price' => '0.1987', 'change' => '-0.34', 'isPositive' => false, 'high' => 0.200, 'low' => 0.197, 'volume' => 0],
            'TRYUSDT' => ['price' => '0.0312', 'change' => '-0.56', 'isPositive' => false, 'high' => 0.0314, 'low' => 0.0310, 'volume' => 0],
            'EURUSDT' => ['price' => '1.0856', 'change' => '0.18', 'isPositive' => true, 'high' => 1.087, 'low' => 1.084, 'volume' => 0],
            'GBPUSDT' => ['price' => '1.2734', 'change' => '0.25', 'isPositive' => true, 'high' => 1.275, 'low' => 1.272, 'volume' => 0],
            'AUDUSDT' => ['price' => '0.6734', 'change' => '0.32', 'isPositive' => true, 'high' => 0.675, 'low' => 0.672, 'volume' => 0],
            'NZDUSDT' => ['price' => '0.6123', 'change' => '-0.19', 'isPositive' => false, 'high' => 0.614, 'low' => 0.611, 'volume' => 0],

            // Precious Metals
            'XAGUSD' => ['price' => '24.56', 'change' => '1.23', 'isPositive' => true, 'high' => 24.7, 'low' => 24.3, 'volume' => 0],
            'XAUUSD' => ['price' => '2043.67', 'change' => '0.87', 'isPositive' => true, 'high' => 2050, 'low' => 2035, 'volume' => 0],
            'XPTUSD' => ['price' => '934.21', 'change' => '-0.45', 'isPositive' => false, 'high' => 938, 'low' => 930, 'volume' => 0],
        ];
    }
}
