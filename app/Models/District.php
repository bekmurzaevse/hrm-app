<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class District extends Model
{

    protected $fillable = [
        'title',
        'region_id',
    ];

    public $timestamps = false;

    /**
     * Summary of region
     * @return BelongsTo<Region, District>
     */
    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }
}
