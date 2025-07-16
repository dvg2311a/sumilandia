<?php

namespace App\Providers;

use App\Models\Level;
use App\Models\Unit;
use App\Policies\LevelPolicy;
use App\Policies\UnitPolicy;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;



class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Gate::policy(Level::class, LevelPolicy::class);
        Gate::policy(Unit::class, UnitPolicy::class);
    }
}
