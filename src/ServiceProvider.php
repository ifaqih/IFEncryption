<?php

namespace IFaqih\Library;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Registers the package as a service provider,
 * also injects the blade directives.
 *
 * @package hisorange\BrowserDetect
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the custom blade directives.
     *
     * @inheritDoc
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerDirectives();

        $source = realpath($raw = __DIR__ . '/../config/if-encryption.php') ?: $raw;

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $source => config_path('if-encryption.php'),
            ]);
        }

        $this->mergeConfigFrom($source, 'if-encryption');
    }


    public function register(): void
    {
        $this->app->singleton('if-encryption', function ($app) {
            return new Parser($app->make('cache'), $app->make('request'), $app->make('config')['if-encryption'] ?? []);
        });
    }
}
