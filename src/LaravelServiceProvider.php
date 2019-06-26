<?php

namespace Halpdesk\LaravelMinimumPackage;

use Illuminate\Support\ServiceProvider;
use Halpdesk\LaravelMinimumPackage\Contracts\User as UserContract;
use Halpdesk\LaravelMinimumPackage\PackageService;

class LaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__ . '/../config/package-config.php') => config_path('package-config.php'),
        ]);

        // Load database migrations
        $this->loadMigrationsFrom(realpath(__DIR__.'/../database/migrations/'));
    }

    public function register()
    {
        // To merge the configurations, use the mergeConfigFrom method within your service provider's register method
        $this->mergeConfigFrom(realpath(__DIR__ . '/../config/package-config.php'), 'package-config');

        // Model contracts
        $this->app->bind(UserContract::class, function () {
            return app(config('package-config.classes.user'));
        });

        // Facades
        $this->app->bind('LaravelMinimumPackageFacade', function() {
            return app(PackageService::class);
        });
    }
}
