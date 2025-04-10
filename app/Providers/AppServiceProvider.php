<?php

namespace App\Providers;

use App\Repositories\AppointmentRepository\AppointmentRepository;
use App\Repositories\AppointmentRepository\Interfaces\IAppointmentRepository;
use App\Repositories\ProviderRepoistory\InterFaces\IProviderRepository;
use App\Repositories\ProviderRepoistory\ProviderRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind (IProviderRepository::class, ProviderRepository::class);
        $this->app->bind (IAppointmentRepository::class , AppointmentRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
