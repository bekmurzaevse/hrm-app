<?php

namespace App\Providers;

use App\Models\District;
use App\Models\Region;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class FilterServiceProvider extends ServiceProvider
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
        // Regions - forever cache
        if (!Cache::has('regions')) {
            Cache::forever('regions', Region::select('id', 'title')->get());
        }

        // Districts - forever cache
        if (!Cache::has('districts')) {
            Cache::forever('districts', District::select('id', 'region_id', 'title')->get());
        }
    }
}
