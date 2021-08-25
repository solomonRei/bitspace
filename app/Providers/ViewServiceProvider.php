<?php

namespace App\Providers;

use App\Http\ViewComposers\LanguageComposer;
use App\Http\ViewComposers\UserComposer;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(
            '*', LanguageComposer::class
        );
        view()->composer(
            '*', UserComposer::class
        );
    }
}
