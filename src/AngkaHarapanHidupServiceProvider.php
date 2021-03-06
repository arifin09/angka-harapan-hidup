<?php namespace Bantenprov\AngkaHarapanHidup;

use Illuminate\Support\ServiceProvider;
use Bantenprov\AngkaHarapanHidup\Console\Commands\AngkaHarapanHidupCommand;

/**
 * The AngkaHarapanHidupServiceProvider class
 *
 * @package Bantenprov\AngkaHarapanHidup
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class AngkaHarapanHidupServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // Bootstrap handles
        $this->routeHandle();
        $this->configHandle();
        $this->langHandle();
        $this->viewHandle();
        $this->assetHandle();
        $this->migrationHandle();
        $this->publicHandle();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('angka-harapan-hidup', function ($app) {
            return new AngkaHarapanHidup;
        });

        $this->app->singleton('command.angka-harapan-hidup', function ($app) {
            return new AngkaHarapanHidupCommand;
        });

        $this->commands('command.angka-harapan-hidup');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'angka-harapan-hidup',
            'command.angka-harapan-hidup',
        ];
    }

    /**
     * Loading package routes
     *
     * @return void
     */
    protected function routeHandle()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
    }

    /**
     * Loading and publishing package's config
     *
     * @return void
     */
    protected function configHandle()
    {
        $packageConfigPath = __DIR__.'/config/config.php';
        $appConfigPath     = config_path('angka-harapan-hidup.php');

        $this->mergeConfigFrom($packageConfigPath, 'angka-harapan-hidup');

        $this->publishes([
            $packageConfigPath => $appConfigPath,
        ], 'config');
    }

    /**
     * Loading and publishing package's translations
     *
     * @return void
     */
    protected function langHandle()
    {
        $packageTranslationsPath = __DIR__.'/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'angka-harapan-hidup');

        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/angka-harapan-hidup'),
        ], 'lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function viewHandle()
    {
        $packageViewsPath = __DIR__.'/resources/views';

        $this->loadViewsFrom($packageViewsPath, 'angka-harapan-hidup');

        $this->publishes([
            $packageViewsPath => resource_path('views/vendor/angka-harapan-hidup'),
        ], 'views');
    }

    /**
     * Publishing package's assets (JavaScript, CSS, images...)
     *
     * @return void
     */
    protected function assetHandle()
    {
        $packageAssetsPath = __DIR__.'/resources/assets';

        $this->publishes([
            $packageAssetsPath => resource_path('assets'),
        ], 'angka-harapan-hidup-assets');
    }

    /**
     * Publishing package's migrations
     *
     * @return void
     */
    protected function migrationHandle()
    {
        $packageMigrationsPath = __DIR__.'/database/migrations';

        $this->loadMigrationsFrom($packageMigrationsPath);

        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], 'migrations');
    }

    public function publicHandle()
    {
        $packagePublicPath = __DIR__.'/public';

        $this->publishes([
            $packagePublicPath => base_path('public')
        ], 'angka-harapan-hidup-public');
    }
}
