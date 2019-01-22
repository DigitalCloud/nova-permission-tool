<?php

namespace DigitalCloud\PermissionTool;

use Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\Events\ServingNova;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use DigitalCloud\PermissionTool\Http\Middleware\Authorize;
use DigitalCloud\PermissionTool\Policies\PermissionPolicy;
use DigitalCloud\PermissionTool\Policies\RolePolicy;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'PermissionTool');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'PermissionTool');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/PermissionTool'),
        ], 'PermissionTool-lang');
        $this->app->booted(function () {
            $this->routes();
        });

        Gate::policy(config('permission.models.permission'), PermissionPolicy::class);
        Gate::policy(config('permission.models.role'), RolePolicy::class);
        
        //Super admin all permissions
        Gate::before(function ($user, $ability) {
            if ($user->email == 'mail@example.com') {
                return true;
            }
        });
        
        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/PermissionTool')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
