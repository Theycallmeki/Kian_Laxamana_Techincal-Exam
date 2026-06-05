<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\Factory;
use App\Observers\ModelActivityObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Factory::observe(ModelActivityObserver::class);
        Employee::observe(ModelActivityObserver::class);
    }
}