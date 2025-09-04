<?php

namespace App\Observers;

use App\Models\District;
use Illuminate\Support\Facades\Cache;

class DistrictObserver
{
    public function saved(District $district)
    {
        Cache::forget('districts');
        Cache::forever('districts', District::select('id', 'region_id', 'title')->get());
    }

    public function deleted(District $district)
    {
        Cache::forget('districts');
        Cache::forever('districts', District::select('id', 'region_id', 'title')->get());
    }
}