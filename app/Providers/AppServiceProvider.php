<?php

namespace App\Providers;

use App\User;

use Doctrine\DBAL\Schema\View;
use Illuminate\View\View as ViewView;
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
        view()->share('total_balance', User::sum('balance'));
    }
}
