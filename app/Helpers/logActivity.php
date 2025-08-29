<?php

// use App\Models\Activity;

use App\Models\UserActivity;

if (! function_exists('logActivity')) {
    function logActivity($title, $text) {
        UserActivity::create([
            'title' => $title,
            'user_id' => auth()->user()->id,
            'text' => $text,
        ]);
    }
}
