<?php
namespace HobbIoT\Auth;

use Illuminate\Support\ServiceProvider;

class CacheableAuthUserServiceProvider extends ServiceProvider
{

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app['auth']->provider('cacheableEloquent',
            function($app, $config) {
                $config['model']::updated(function ($model) {
                    CacheableEloquentUserProvider::clearCache($model);
                });
                return new CacheableEloquentUserProvider($app['hash'], $config['model']);
            }
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }

}
