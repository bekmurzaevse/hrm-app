<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'path',
        'type',
        'attachable_type',
        'attachable_id',
        'size',
    ];

    /**
     * Summary of casts
     * @return array{created_at: string, updated_at: string}
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Summary of fileable
     * @return MorphTo<Model, File>
     */
    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function client()
    {
        return $this->morphTo()->where('fileable_type', Client::class);
    }
}
