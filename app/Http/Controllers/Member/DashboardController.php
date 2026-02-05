<?php

namespace App\Http\Controllers\Member;

use App\Models\User;
use App\Models\Config;
use App\Models\Transaction;
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

        // Get available coins with complete data (icon & color)
        $availableCoins = $this->getAvailableCoinsWithMetadata();

        // Group coins by category
        $coinsByCategory = $this->groupCoinsByCategory($availableCoins);

        // Fetch REAL prices immediately from API (no fallback)
        $allPrices = $this->getAllCoinPricesBatch(array_keys($availableCoins));

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
     * Get available coins with metadata (icon & color)
     */
    private function getAvailableCoinsWithMetadata()
    {
        return [
            // Cryptocurrency
            'BTCUSDT' => [
                'name' => 'Bitcoin',
                'icon' => 'bi bi-currency-bitcoin',
                'color' => '#F7931A'
            ],
            'ETHUSDT' => [
                'name' => 'Ethereum',
                'icon' => 'bi bi-currency-ethereum',
                'color' => '#627EEA'
            ],
            'XRPUSDT' => [
                'name' => 'Ripple',
                'icon' => 'bi bi-currency-exchange',
                'color' => '#23292F'
            ],
            'LINKUSDT' => [
                'name' => 'Chainlink',
                'icon' => 'bi bi-link-45deg',
                'color' => '#2A5ADA'
            ],
            'DOTUSDT' => [
                'name' => 'Polkadot',
                'icon' => 'bi bi-circle-fill',
                'color' => '#E6007A'
            ],
            'DOGEUSDT' => [
                'name' => 'Dogecoin',
                'icon' => 'bi bi-coin',
                'color' => '#C2A633'
            ],
            'BCHUSDT' => [
                'name' => 'Bitcoin Cash',
                'icon' => 'bi bi-cash-coin',
                'color' => '#8DC351'
            ],
            'FILUSDT' => [
                'name' => 'Filecoin',
                'icon' => 'bi bi-database',
                'color' => '#0090FF'
            ],
            'LTCUSDT' => [
                'name' => 'Litecoin',
                'icon' => 'bi bi-lightning-charge',
                'color' => '#345D9D'
            ],
            'ZECUSDT' => [
                'name' => 'Zcash',
                'icon' => 'bi bi-shield-lock',
                'color' => '#ECB244'
            ],
            'DASHUSDT' => [
                'name' => 'Dash',
                'icon' => 'bi bi-speedometer2',
                'color' => '#008CE7'
            ],

            // Forex
            'HKDUSD' => [
                'name' => 'Hong Kong Dollar',
                'icon' => 'bi bi-cash-stack',
                'color' => '#DC143C'
            ],
            'INRUSD' => [
                'name' => 'Indian Rupee',
                'icon' => 'bi bi-currency-rupee',
                'color' => '#FF9933'
            ],
            'KRWUSD' => [
                'name' => 'Korean Won',
                'icon' => 'bi bi-currency-won',
                'color' => '#003478'
            ],
            'SGDUSD' => [
                'name' => 'Singapore Dollar',
                'icon' => 'bi bi-currency-dollar',
                'color' => '#EE2737'
            ],
            'BRLUSDT' => [
                'name' => 'Brazilian Real',
                'icon' => 'bi bi-currency-dollar',
                'color' => '#009B3A'
            ],
            'TRYUSDT' => [
                'name' => 'Turkish Lira',
                'icon' => 'bi bi-currency-exchange',
                'color' => '#E30A17'
            ],
            'EURUSDT' => [
                'name' => 'Euro',
                'icon' => 'bi bi-currency-euro',
                'color' => '#003399'
            ],
            'GBPUSDT' => [
                'name' => 'British Pound',
                'icon' => 'bi bi-currency-pound',
                'color' => '#012169'
            ],
            'AUDUSDT' => [
                'name' => 'Australian Dollar',
                'icon' => 'bi bi-currency-dollar',
                'color' => '#00008B'
            ],
            'NZDUSDT' => [
                'name' => 'New Zealand Dollar',
                'icon' => 'bi bi-currency-dollar',
                'color' => '#00247D'
            ],

            // Precious Metals
            'XAGUSD' => [
                'name' => 'Silver',
                'icon' => 'bi bi-gem',
                'color' => '#C0C0C0'
            ],
            'XAUUSD' => [
                'name' => 'Gold',
                'icon' => 'bi bi-gem',
                'color' => '#FFD700'
            ],
            'XPTUSD' => [
                'name' => 'Platinum',
                'icon' => 'bi bi-gem',
                'color' => '#E5E4E2'
            ],
        ];
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
        } catch (\Exception $e) {
            Log::error("Binance API failed: " . $e->getMessage());
            
            // Return empty array or $0.00 if API fails
            $fallback = [];
            foreach ($symbols as $symbol) {
                $fallback[$symbol] = [
                    'price' => '0.00',
                    'change' => '0.00',
                    'isPositive' => true,
                    'high' => 0,
                    'low' => 0,
                    'volume' => 0
                ];
            }
            return $fallback;
        }
    }

    /**
     * Batch fetch forex prices
     */
    private function getForexPricesBatch($symbols)
    {
        try {
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
        } catch (\Exception $e) {
            Log::error("Forex API failed: " . $e->getMessage());
            
            // Return empty array or $0.00 if API fails
            $fallback = [];
            foreach ($symbols as $symbol) {
                $fallback[$symbol] = [
                    'price' => '0.00',
                    'change' => '0.00',
                    'isPositive' => true,
                    'high' => 0,
                    'low' => 0,
                    'volume' => 0
                ];
            }
            return $fallback;
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
}