<?php

namespace App\Providers;

use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Model::shouldBeStrict(!$this->app->isProduction());
        Model::preventsSilentlyDiscardingAttributes(!$this->app->isProduction());

        if ($this->app->isProduction()) {
            DB::whenQueryingForLongerThan(CarbonInterval::seconds(5), function (Connection $connection) {
                logger()->channel('telegram')->debug('whenQueryingForLongerThan: ' . $connection->totalQueryDuration());
            });

            DB::listen(static function ($query) {
                if ($query->time > 100) {
                    logger()->channel('telegram')->debug('Long query: ' . $query->sql, $query->nindings);
                }
            });

            $kernel = app(\Illuminate\Foundation\Http\Kernel::class);

            $kernel->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function () {
                    logger()->channel('telegram')->debug('Long request: ' . request()->url());
                }
            );
        }
    }
}
