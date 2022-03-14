<?php

namespace App\Models\Traits;

use Illuminate\Support\Carbon;

/**
 * Trait TimeByDay
 */
trait DateTimeByDayAndTime
{
    private function getDateTimeByDateAndTime(Carbon $date, Carbon $time)
    {
        return $date->setTime($time->hour, $time->minute, $time->second);
    }
}
