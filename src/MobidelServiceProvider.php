<?php

namespace Zakhariy\MobidelLaravel;

use Barryvdh\Cors\HandleCors;
use GuzzleHttp\Client;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Symfony\Component\EventDispatcher\EventDispatcher;

class MobidelServiceProvider extends EventServiceProvider
{
    public function register()
    {
        $configPath = dirname(__DIR__) . '/config/mobidel.php';
        $this->mergeConfigFrom($configPath, 'mobidel');
        $this->publishes([$configPath => config_path('mobidel.php')], 'config');

        $this->app->singleton(MobidelApi::class, function ($app) {
            $config = $this->app->make('config')->get('mobidel');
            return new MobidelApi(new Client(), $config['user'], $config['password'], $config['wid']);
        });
        $this->app->alias(MobidelApi::class, 'mobidel_api');

        $this->app->singleton(MobidelCallback::class, function ($app) {
            return new MobidelCallback(
                new EventDispatcher(),
                app()->make('log')
            );
        });
        $this->app->alias(MobidelCallback::class, 'mobidel_callback');
        $this->app->make('router')->aliasMiddleware('cors-middleware', HandleCors::class);
    }

    public function boot()
    {
        $config = $this->app->make('config')->get('mobidel');
        $this->app['router']->group(['prefix' => $config['route_prefix']], function ($router) use ($config) {
            $router->post($config['route_path'], [
                'as' => 'callback.index',
                'uses' => 'Zakhariy\MobidelLaravel\Controllers\CallbackController@index'
            ])->middleware('cors-middleware');
        });
    }

}