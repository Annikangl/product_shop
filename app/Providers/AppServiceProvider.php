<?php

namespace App\Providers;

use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Model::shouldBeStrict(!$this->app->isProduction());
        Model::preventsSilentlyDiscardingAttributes(!$this->app->isProduction());

        if ($this->app->isProduction()) {

            DB::listen(static function ($query) {
                if ($query->time > 100) {
                    logger()->channel('telegram')->debug('Long query: ' . $query->sql, $query->nindings);
                }
            });

            app(Kernel::class)->whenRequestLifecycleIsLongerThan(
                CarbonInterval::seconds(4),
                function () {
                    logger()->channel('telegram')->debug('Long request: ' . request()->url());
                }
            );
        }
    }
}
