<?php

namespace App\Observers;

use App\Traits\ClearCache;

class ClientObserver
{
    use ClearCache;

    /**
     * Summary of created
     * @return void
     */
    public function created(): void
    {
        $this->clear([
            'clients',
            'clients:show',
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
            'clients',
            'clients:show',
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
            'clients',
            'clients:show',
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
            'clients',
            'clients:show',
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
            'clients',
            'clients:show',
            'dashboard',
        ]);
    }
}
