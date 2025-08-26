<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        \App\Models\Candidate::observe(\App\Observers\CandidateObserver::class);
        \App\Models\Client::observe(\App\Observers\ClientObserver::class);
        \App\Models\Interaction::observe(\App\Observers\InteractionObserver::class);
        \App\Models\Type::observe(\App\Observers\TypeObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\Project::observe(\App\Observers\ProjectObserver::class);
        \App\Models\Vacancy::observe(\App\Observers\VacancyObserver::class);
    }
}
