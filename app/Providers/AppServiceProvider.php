<?php
namespace App\Providers;

use App\Services\AppDistributionService;
use Domain\Distribution\Repositories\InvestmentDistributionRepository;
use Domain\Distribution\Services\InvestmentDistributionBase;
use Domain\Distribution\Services\InvestmentDistributionService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AppDistributionService::class, function ($app) {
            return new AppDistributionService(
                new InvestmentDistributionService($app->make(InvestmentDistributionBase::class)),
                $app->make(InvestmentDistributionRepository::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
