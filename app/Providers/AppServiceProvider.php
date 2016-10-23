<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\HashedWord;
use App\Observers\HashedWordObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        HashedWord::observe(HashedWordObserver::class);
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
