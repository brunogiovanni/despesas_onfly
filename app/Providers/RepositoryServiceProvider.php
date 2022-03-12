<?php

namespace App\Providers;

use App\Repositories\DespesaRepository;
use App\Repositories\DespesaRepositoryInterface;
use App\Services\DespesaService;
use App\Services\DespesaServiceInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(DespesaRepositoryInterface::class, DespesaRepository::class);
        $this->app->bind(DespesaServiceInterface::class, DespesaService::class);
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
