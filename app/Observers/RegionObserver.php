<?php

namespace App\Observers;

use App\Models\Region;
use Illuminate\Support\Facades\Cache;


class RegionObserver
{
    public function saved(Region $region)
    {
        Cache::forget('regions');
        Cache::forever('regions', Region::select('id', 'title')->get());
    }

    public function deleted(Region $region)
    {
        Cache::forget('regions');
        Cache::forever('regions', Region::select('id', 'title')->get());
    }
}