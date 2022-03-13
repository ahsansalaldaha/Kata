<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Exception;

class Schedule extends Model
{
    use HasFactory;

    public function breaks()
    {
        return $this->hasMany(ExclusiveBreak::class);
    }

    public function repeat()
    {
        return $this->belongsTo(Repeat::class);
    }

    public function scopeDay($day)
    {
        return $this->where('day', $day);
    }

    public function isWithinSchedule(Carbon $time)
    {
        return $time->isBetween($this->start, $this->end, true);
    }

    public function isValidWeek(Carbon $datetime): bool
    {
        if ($datetime->isUtc()) {
            throw new Exception("Datetime must be in UTC format", 422);
        }
        if (!$datetime->isStartOfDay()) {
            throw new Exception("Datetime must be start of the day", 422);
        }

        if ($datetime->format('l') != $this->day) {
            throw new Exception("Datetime must be of same day", 422);
        }

        if (!$this->repeat) {
            throw new Exception("Repeat not set", 422);
        }
        if ($this->repeat->type !== 'week') {
            throw new Exception("Other types not implemented yet", 423);
        }
        if ($this->repeat->every == 1) {
            return true;
        }

        $start_day = $this->start_date->setTimezone('UTC')->startOfDay();

        $weeks_count = 0;
        while ($start_day->isBefore($datetime) || $start_day->equal($datetime)) {
            if (++$weeks_count == $this->repeat->every || $weeks_count == 1) {
                return true;
            }
            $start_day->addWeek();
        }
        return false;
    }
}
