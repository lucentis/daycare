<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('CODESPACE_NAME')) {
        $domain = env('GITHUB_CODESPACES_PORT_FORWARDING_DOMAIN');
        $name   = env('CODESPACE_NAME');

        config(['app.url' => "https://{$name}-8000.{$domain}"]);
        URL::forceRootUrl(config('app.url'));
        URL::forceScheme('https');
    }
    }
}
