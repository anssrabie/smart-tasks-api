<?php

use Carbon\Carbon;

if (!function_exists('showDate')){
    function showDate($date, $format = 'd-M-Y H:i'): string
    {
        if ($format === 'human') {
            return Carbon::parse($date)->diffForHumans();
        }
        return Carbon::parse($date)->format($format);
    }
}
