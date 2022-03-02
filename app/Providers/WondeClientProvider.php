<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Wonde\Client;
use Wonde\Endpoints\Classes;
use Wonde\Endpoints\Employees;
use Wonde\Endpoints\Schools;

class WondeClientProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Client::class, function ($app) {
            return new Client(env("WONDE_API_KEY"));
        });

        $this->app->bind(Schools::class, function ($app) {
            return $app->make(Client::class)->school(env("WONDE_SCHOOL_ID"));
        });

        $this->app->bind(Employees::class, function ($app) {
            return $app->make(Schools::class)->employees;
        });

        $this->app->bind(Classes::class, function ($app) {
            return $app->make(Schools::class)->classes;
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
