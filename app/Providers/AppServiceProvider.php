<?php

namespace App\Providers;

use App\Interfaces\RobotSimulatorInterface;
use App\Repositories\RobotSimulatorRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RobotSimulatorInterface::class, RobotSimulatorRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
