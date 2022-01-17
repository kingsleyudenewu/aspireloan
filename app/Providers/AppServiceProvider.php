<?php

namespace App\Providers;

use App\Contracts\BaseRepositoryInterface;
use App\Contracts\LoanApplicationInterface;
use App\Contracts\LoanScheduleInterface;
use App\Contracts\LoanTypeInterface;
use App\Repository\BaseRepository;
use App\Repository\LoanApplicationRepository;
use App\Repository\LoanScheduleRepository;
use App\Repository\LoanTypeRepository;
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
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(LoanTypeInterface::class, LoanTypeRepository::class);
        $this->app->bind(LoanApplicationInterface::class, LoanApplicationRepository::class);
        $this->app->bind(LoanScheduleInterface::class, LoanScheduleRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
