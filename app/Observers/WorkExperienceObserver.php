<?php

namespace App\Observers;

use App\Traits\ClearCache;
use Illuminate\Support\Facades\Log;

class WorkExperienceObserver
{
    use ClearCache;

    /**
     * Summary of created
     * @return void
     */
    public function created(): void
    {
        Log::alert("Jaratildi");

        $this->clear([
            'candidates',
            'candidates:show',
        ]);
    }

    /**
     * Summary of updated
     * @return void
     */
    public function updated(): void
    {
        Log::alert("O'zgertildi");

        $this->clear([
            'candidates',
            'candidates:show',
        ]);
    }

    /**
     * Summary of deleted
     * @return void
     */
    public function deleted(): void
    {
        Log::alert("O'shirildi");
        $this->clear([
            'candidates',
            'candidates:show',
        ]);
    }

    /**
     * Summary of restored
     * @return void
     */
    public function restored(): void
    {
        $this->clear([
            'candidates',
            'candidates:show',
        ]);
    }

    /**
     * Summary of forceDeleted
     * @return void
     */
    public function forceDeleted(): void
    {
        $this->clear([
            'candidates',
            'candidates:show',
        ]);
    }
}
