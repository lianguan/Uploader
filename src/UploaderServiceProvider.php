<?php

/*
 * This file is part of Gitamin.
 *
 * Copyright (C) 2015-2016 The Gitamin Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phecho\Uploader;

use Illuminate\Support\ServiceProvider;

class UploaderServiceProvider extends ServiceProvider
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
        // Publish config files
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('uploader.php'),
        ], 'config');

        // Define the route
        $routeConfig = [
            'namespace' => 'Phecho\Uploader',
        ];

        if ($this->app['config']->get('uploader.middleware')) {
            $routeConfig['middleware'] = $this->app['config']->get('uploader.middleware');
        }

        $this->app['router']->group($routeConfig, function ($router) {
            $router->any($this->app['config']->get('uploader.route', 'uploader').'/{type?}', [
                'uses' => 'UploaderController@index',
                'as' => 'uploader',
            ]);
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //sad
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
