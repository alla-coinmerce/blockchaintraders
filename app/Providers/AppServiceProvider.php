<?php

namespace App\Providers;

use App\Contracts\CoinRepository;
use App\Contracts\FundSnapshotExportService;
use App\Infrastructure\Repositories\CoinGeckoRepository;
use App\Services\FundSnapshotCsvExportService;
use App\Services\Subscribe;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Subscribe::class, function (Application $app) {
            return new Subscribe();
        });

        $this->app->bind(CoinRepository::class, CoinGeckoRepository::class);

        $this->app->bind(FundSnapshotExportService::class, FundSnapshotCsvExportService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->environment('local')) {
            Mail::alwaysTo('michel@wpextensio.com');
        }

        if ($this->app->environment('staging')) {
            // Mail::alwaysTo('michel@wpextensio.com');
            Mail::alwaysTo('info@blockchaintraders.nl');
        }
    }
}
