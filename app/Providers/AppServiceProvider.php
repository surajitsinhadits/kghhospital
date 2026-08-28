<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;

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
        Blade::directive('isok', function ($expression) {
            return "<?php if(collect(explode(',', $expression))->filter(function(\$value) {
                \$permissions = session('permissions');
                if (\$permissions instanceof \Illuminate\Support\Collection) {
                    \$permissions = \$permissions->toArray();
                }
                return in_array(trim(\$value), \$permissions);
            })->isNotEmpty()): ?>";
        });

        Blade::directive('endisok', function () {
            return "<?php endif; ?>";
        });

        Paginator::useBootstrap();
    }
}
