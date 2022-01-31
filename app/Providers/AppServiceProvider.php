<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use App\Models\Test;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // share global to use in nav... 
        $tests = Test::whereNull('ergebnis')->with('kunde')->get();
        View::share('inwartezeit', $tests);
    }
}
