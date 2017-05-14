<?php

namespace Sijot\Providers;

use Illuminate\Support\ServiceProvider;
use Sijot\News;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('layouts.modules.footer', function ($view) {
            $view->with('posts', News::orderBy('created_at', 'asc')->take(3)->get());
        });
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
