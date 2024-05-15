<?php

namespace BizyTech\Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AuthUIServiceProvider extends ServiceProvider
{
    /**
     * Register the package services.
     *
     * @return void
     */
    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                AuthCommand::class,
                ControllersCommand::class,
                UiCommand::class,
            ]);
        }

       // $this->registerRoutes();
    }

    protected function registerRoutes(){
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Route::mixin(new AuthRouteMethods);
        $this->loadViewsFrom(__DIR__.'/../resources/views','bizytech');
        $this->registerRoutes();

        /*        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views'),
        ],'resource');
*/

        /*
     $this->publishes([
            __DIR__.'/../public' => base_path('public')
        ], 'public');
     */

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        /*        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'migrations');
*/

        //$this->seeding();
        $this->publishAll();
    }

    public function seeding(): void
    {
        $this->publishes([
            __DIR__.'/../database/seeders/' => database_path('seeders')
        ], 'bizytech-seeders');
    }

    private function publishAll(): void
    {
        $this->publishes([
            __DIR__.'/../public' => base_path('public'),
            __DIR__.'/../resources/views/layouts' => base_path('resources/views/layouts'),
            __DIR__.'/../resources/views/common' => base_path('resources/views/commons'),
            __DIR__.'/../config' => base_path('config'),
           // __DIR__.'/../database/seeders/' => database_path('seeders'),
        ], 'bizytech');
    }
}
