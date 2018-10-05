<?php
declare(strict_types = 1);

namespace Crazybooot\ConstantsToJs\Providers;

use Crazybooot\ConstantsToJs\Console\Commands\GenerateJsFileCommand;
use Crazybooot\ConstantsToJs\Generators\GeneratorContract;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use function config;
use function config_path;

/**
 * Class ServiceProvider
 *
 * @package Crazybooot\ConstantsToJs\Providers
 */
class ServiceProvider extends BaseServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(GenerateJsFileCommand::class);
        }

        $this->app->bind(GeneratorContract::class, function ($app) {
            $generator = config('constants-to-js.generator');
            
            return new $generator();
        });

        $this->publishes([
            __DIR__.'/../../config/constants-to-js.php' => config_path('constants-to-js.php'),
        ], 'config');
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/constants-to-js.php', 'constants-to-js'
        );
    }
}