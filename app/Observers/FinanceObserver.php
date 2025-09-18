<?php

namespace App\Observers;

use App\Traits\ClearCache;

class FinanceObserver
{
    use ClearCache;

    /**
     * Summary of created
     * @return void
     */
    public function created(): void
    {
        $this->clear([
            'finances',
            'finances:show',
            'dashboard',
        ]);
    }

    /**
     * Summary of updated
     * @return void
     */
    public function updated(): void
    {
        $this->clear([
            'finances',
            'finances:show',
            'dashboard',
        ]);
    }

    /**
     * Summary of deleted
     * @return void
     */
    public function deleted(): void
    {
        $this->clear([
            'finances',
            'finances:show',
            'dashboard',
        ]);
    }

    /**
     * Summary of restored
     * @return void
     */
    public function restored(): void
    {
        $this->clear([
            'finances',
            'finances:show',
            'dashboard',
        ]);
    }

    /**
     * Summary of forceDeleted
     * @return void
     */
    public function forceDeleted(): void
    {
        $this->clear([
            'finances',
            'finances:show',
            'dashboard',
        ]);
    }
}
