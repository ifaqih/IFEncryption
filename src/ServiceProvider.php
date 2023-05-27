<?php

namespace IFaqih\IFEncryption;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * Registers the package as a service provider,
 * also injects the blade directives.
 *
 * @package hisorange\BrowserDetect
 */
class ServiceProvider extends BaseServiceProvider
{

    public function boot(): void
    {

        $source = realpath($raw = __DIR__ . '/../config/if-encryption.php') ?: $raw;

        if ($this->app->runningInConsole()) {
            $this->publishes([
                $source => config_path('if-encryption.php'),
            ], "if-encryption-config");
        }

        $this->mergeConfigFrom($source, 'if-encryption');
    }


    public function register(): void
    {
    }
}
