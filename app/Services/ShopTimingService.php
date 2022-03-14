<?php

namespace App\Services;

use App\Interfaces\AvailabilityInterface;
use App\Interfaces\CurrentAvailabilityInterface;
use App\Interfaces\NextAvailabilityInterface;
use App\Models\Repeat;
use Illuminate\Support\Carbon;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

class ShopTimingService implements CurrentAvailabilityInterface, AvailabilityInterface, NextAvailabilityInterface
{

    private function getSchedule(Carbon $date): ?Schedule
    {
        return Schedule::day($date->format('l'))->with(['breaks', 'repeat'])->first();
    }

    private function getValidWeekSchedule(Carbon $date): ?Schedule
    {
        $schedule =  Schedule::day($date->format('l'))->with(['breaks', 'repeat'])->first();
        if (!$schedule) {
            return null;
        }
        return $schedule->isValidWeek($date->copy()->startOfDay()->utc()) ? $schedule : null;
    }

    public function isOpen(): bool
    {
        $current_time = Carbon::now()->utc();
        return $this->isOpenOn($current_time);
    }

    public function isOpenOn(Carbon $date): bool
    {
        $todays_schedule = $this->getValidWeekSchedule($date);

        if (!$todays_schedule) {
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

            if (!$todays_schedule) {
                if ($datetime =  $this->getNextSchedule($current_time->addDay())) {
                    return $datetime;
                }
                return null;
            }

            if ($todays_schedule->isWithinSchedule($current_time)) {
                foreach ($todays_schedule->breaks as $break) {
                    if ($break->isWithinBreak($current_time)) {
                        return $break->getEndByDay($current_time);
                    }
                }
            }

            if ($current_time->isAfter($todays_schedule->getEndByDay($current_time))) {
                $datetime = $this->getNextSchedule($current_time->addDay());
                if ($datetime) {
                    return $datetime;
                }
            }

            $datetime = $this->getNextSchedule($current_time);
            if ($datetime) {
                return $datetime;
            }

            return null;
        }

        // Will return current meaning its open right now
        return null;
    }

    private function getNextSchedule(Carbon $for): ?Carbon
    {
        $date = $for->copy();
        $days_loop = 0;

        // Need to update if we shift to other types of repeat
        $max_repeat = Repeat::where('type', 'week')->max('every');
        while (!($schedule = $this->getSchedule($date))) {
            // If we have looped through all the days adding repeat then maybe schedule is not set
            if (++$days_loop > (7 * $max_repeat)) {
                return null;
            }
            $date = $date->addDay();
        }

        $date_utc = $date->copy()->startOfDay()->utc();
        if (!$schedule->isValidWeek($date_utc)) {
            return $this->getNextSchedule($date->addDay());
        }
        $start_of_shift =  $schedule->getStartByDay($date);
        return $start_of_shift;
    }
}
