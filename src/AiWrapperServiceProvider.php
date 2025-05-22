<?php

namespace adeel696\AiWrapper;

use Illuminate\Support\ServiceProvider;
use adeel696\AiWrapper\Contracts\AiProviderInterface;
use adeel696\AiWrapper\Providers\OpenAiProvider;

class AiWrapperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/aiwrapper.php', 'aiwrapper');

        $this->app->singleton(AiProviderInterface::class, function () {
            return new OpenAiProvider();
        });

        $this->app->singleton('ai', function ($app) {
            return new AiManager($app->make(AiProviderInterface::class));
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/aiwrapper.php' => config_path('aiwrapper.php'),
        ]);
    }
}
