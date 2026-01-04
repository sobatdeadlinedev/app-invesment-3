<?php

namespace App\Http\View\Composers;

use App\Models\Config;
use Illuminate\View\View;

class ConfigComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        $appConfig = [
            'app_name' => Config::get('app_name', ['value' => 'My App']),
            'app_logo' => Config::get('app_logo', ['value' => asset('assets/media/logos/logo-ji.png')]),
            'app_announcement' => Config::get('app_announcement', ['value' => '']),
            'app_wallet_address' => Config::get('app_wallet_address', ['name' => '', 'number' => '']),
            'app_qr_code' => Config::get('app_qr_code', ['value' => '']),
        ];

        $view->with('appConfig', $appConfig);
    }
}
