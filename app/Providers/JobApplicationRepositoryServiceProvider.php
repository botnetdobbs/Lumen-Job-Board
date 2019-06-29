<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Interfaces\JobApplicationInterface;
use App\Repositories\Services\JobApplicationService;

class JobApplicationRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            JobApplicationInterface::class,
            JobApplicationService::class
        );
    }
}
