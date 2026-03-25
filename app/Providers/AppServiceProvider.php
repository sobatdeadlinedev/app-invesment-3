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
            'admin.layouts.app',
    'admin.components.sidebar',
    'member.components.header',
    'member.layouts.app',
    'auth.pages.login.index',
    'auth.pages.register.index',
    'auth.pages.register.verify-otp',          // ← tambahkan ini
    'auth.pages.forget-password.index',
    'auth.pages.forget-password.reset-password',
    'auth.pages.forget-password.verify-otp',
        ], ConfigComposer::class);
    }
}
