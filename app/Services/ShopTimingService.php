<?php

namespace App\Services;

use App\Interfaces\AvailabilityInterface;
use App\Interfaces\CurrentAvailabilityInterface;
use App\Interfaces\NextAvailabilityInterface;
use App\Models\Repeat;
use Illuminate\Support\Carbon;
use App\Models\Schedule;

class ShopTimingService implements CurrentAvailabilityInterface, AvailabilityInterface, NextAvailabilityInterface
{

    private function getSchedule(Carbon $date): Schedule
    {
        return Schedule::day($date->format('l'))->with(['breaks', 'repeat'])->first();
    }

    public function isOpen(): bool
    {
        $current_time = Carbon::now()->utc();
        return $this->isOpenOn($current_time);
    }

    public function isOpenOn(Carbon $date): bool
    {
        $todays_schedule = $this->getSchedule($date);

        if (!$todays_schedule || !$todays_schedule->isValidWeek($date->copy()->startOfDay())) {
            return false;
        }

        if ($todays_schedule->isWithinSchedule($date)) {
            foreach ($todays_schedule->breaks as $break) {
                if ($break->isWithinBreak($date)) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    public function nextAvailability(): ?Carbon
    {
        if (!$this->isOpen()) {

            $current_time = Carbon::now()->utc();
            $todays_schedule = $this->getSchedule($current_time);

            if (!$todays_schedule || !$todays_schedule->isValidWeek($current_time->copy()->startOfDay())) {
                if ($schedule = $this->getNextDaysSchedule($current_time)) {
                    return $schedule->start;
                }
                return null;
            }

            if ($todays_schedule->isWithinSchedule($current_time)) {
                foreach ($todays_schedule->breaks as $break) {
                    if ($break->isWithinBreak($current_time)) {
                        return $break->end;
                    }
                }
            }

            if ($schedule = $this->getNextDaysSchedule($current_time)) {
                return $schedule->start;
            }
            return null;
        }
        // Will return current meaning its open right now
        return Carbon::now();
    }

    private function getNextDaysSchedule(Carbon $today): Schedule
    {
        $next_day = $today->addDay();
        $days_loop = 0;

        // Need to update if we shift to other types of repeat
        $max_repeat = Repeat::where('type', 'week')->max('every');
        while (!($schedule = $this->getSchedule($next_day))) {
            // If we have looped through all the days adding repeat then maybe schedule is not set
            if (++$days_loop > (7 * $max_repeat)) {
                return null;
            }
            $next_day = $next_day->addDay();
        }

        if (!$schedule->isValidWeek($next_day)) {
            return $this->getNextDaysSchedule($next_day->addDay());
        }
        return $schedule;
    }
}
