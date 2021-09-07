<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Schema::defaultStringLength(191);

        try {

            $data['gs'] = GeneralSetting::first();
        
            View::share($data);

        } catch (\Exception $e) {

            return $e->getMessage();
        }
        //compose all the views....
        view()->composer('*', function ()
        {
            $authUser = Auth::user();
        });
        view()->share(['appUrl' => \Request::root(),'publicPath' => \Request::root()]);
    }
}
