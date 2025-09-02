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
        if (app()->environment('testing')) {
            $regions = collect([
                (object) ['id' => 1, 'title' => 'Toshkent'],
                (object) ['id' => 2, 'title' => 'Samarqand'],
            ]);

            $districts = collect([
                (object) ['id' => 1, 'region_id' => 1, 'title' => 'Yunusobod'],
                (object) ['id' => 2, 'region_id' => 2, 'title' => 'Oqdarvo'],
            ]);

            Cache::forever('regions', $regions);
            Cache::forever('districts', $districts);

            return;
        }

        if (!Cache::has('regions')) {
            Cache::forever('regions', Region::select('id', 'title')->get());
        }

        if (!Cache::has('districts')) {
            Cache::forever('districts', District::select('id', 'region_id', 'title')->get());
        }
    }
}
