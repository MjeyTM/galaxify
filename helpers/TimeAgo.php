<?php
function timeAgo($datetime): string {
    $time_ago = strtotime($datetime); // Convert datetime to timestamp
    $current_time = time(); // Get current timestamp
    $time_difference = $current_time - $time_ago; // Calculate the time difference in seconds
    
    // Time intervals
    $seconds = $time_difference;
    $minutes      = round($seconds / 60);           // 60 seconds = 1 minute
    $hours        = round($seconds / 3600);         // 3600 seconds = 1 hour
    $days         = round($seconds / 86400);        // 86400 seconds = 1 day
    $weeks        = round($seconds / 604800);       // 604800 seconds = 1 week
    $months       = round($seconds / 2629440);      // 2629440 seconds = 1 month
    $years        = round($seconds / 31553280);     // 31553280 seconds = 1 year
    
    // If the time difference is less than 60 seconds
    if ($seconds <= 60) {
        return "Just Now";
    }
    // If the time difference is less than 60 minutes
    else if ($minutes <= 60) {
        if ($minutes == 1) {
            return "1 minute ago";
        } else {
            return "$minutes minutes ago";
        }
    }
    // If the time difference is less than 24 hours
    else if ($hours <= 24) {
        if ($hours == 1) {
            return "1 hour ago";
        } else {
            return "$hours hours ago";
        }
    }
    // If the time difference is less than 7 days
    else if ($days <= 7) {
        if ($days == 1) {
            return "Yesterday";
        } else {
            return "$days days ago";
        }
    }
    // If the time difference is less than 30 days
    else if ($months <= 12) {
        if ($months == 1) {
            return "1 month ago";
        } else {
            return "$months months ago";
        }
    }
    // If the time difference is more than a year
    else {
        if ($years == 1) {
            return "1 year ago";
        } else {
            return "$years years ago";
        }
    }
}