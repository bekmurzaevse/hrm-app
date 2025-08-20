<?php

// use App\Models\Activity;

use App\Models\UserActivity;

if (! function_exists('logActivity')) {
    function logActivity($title, $text) {
        UserActivity::create([
            'title' => $title,
            'user_id' => 1,
            'text' => $text,
        ]);
    }
}
