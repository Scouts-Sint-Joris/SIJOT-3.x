<?php

namespace Sijot\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Schema;
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
        Schema::defaultStringLength(191);

        view()->composer('layouts.modules.footer', function ($view) { // Set the new post for the footer to a variable.
            $view->with('posts', News::orderBy('created_at', 'asc')->take(3)->get());
        });

        view()->composer('*', function ($view) { // Set the authencated user to a variable.
            $view->with('user', auth()->user());
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }
    }
}
