<?php
namespace App\Providers;

use App\Service\MatrixHelperService;
use Illuminate\Support\ServiceProvider;

class MatrixServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(MatrixHelperService::class, function ($app) {
            return new MatrixHelperService();
        });
    }
}
