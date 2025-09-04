<?php

namespace App\Observers;

use App\Traits\ClearCache;

class UserObserver
{
    use ClearCache;

    /**
     * Summary of created
     * @return void
     */
    public function created(): void
    {
        $this->clear([
            'users',
            'users:show',
            'users:list',
        ]);
    }

    /**
     * Summary of updated
     * @return void
     */
    public function updated(): void
    {
        $this->clear([
            'users',
            'users:show',
            'users:list',
        ]);
    }

    /**
     * Summary of deleted
     * @return void
     */
    public function deleted(): void
    {
        $this->clear([
            'users',
            'users:show',
            'users:list',
        ]);
    }

    /**
     * Summary of restored
     * @return void
     */
    public function restored(): void
    {
        $this->clear([
            'users',
            'users:show',
            'users:list',
        ]);
    }

    /**
     * Summary of forceDeleted
     * @return void
     */
    public function forceDeleted(): void
    {
        $this->clear([
            'users',
            'users:show',
            'users:list',
        ]);
    }
}
