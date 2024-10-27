<?php

namespace App\Providers;

use App\Services\GenerateBackendCodeService;
use App\Services\GenerateFrontCodeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
        $this->app->bind(GenerateBackendCodeService::class,function ($app){
            return new GenerateBackendCodeService();
        });
        $this->app->bind(GenerateFrontCodeService::class,function ($app){
            return new GenerateFrontCodeService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (env('APP_DEBUG')) {  // 确保仅在调试模式下开启
            DB::listen(function ($query) {
                Log::channel('sql')->info($query->sql, $query->bindings, $query->time);
            });
        }
    }
}
