<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\View\Composers\ConfigComposer;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer([
            'admin.components.sidebar',
            'member.components.header',
            'auth.pages.login.index',
            'auth.pages.register.index',
        ], ConfigComposer::class);
    }
}
