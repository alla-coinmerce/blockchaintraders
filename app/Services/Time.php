<?php

namespace App\Services;

use Illuminate\Support\Carbon;

class Time
{
    /**
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return string formatted time 'H:i:s'
     */
    public function dateTimeFromDateSetToTwelveHourEuropeAmsterdamTime(string $date)
    {
        return Carbon::createFromTimestamp(strtotime($date))->setTimezone('Europe/Amsterdam')->setTime(12, 0)->setTimezone('UTC');
    }
}