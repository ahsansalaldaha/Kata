<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Traits\DateTimeByDayAndTime;

class Schedule extends Model
{
    use HasFactory;
    use DateTimeByDayAndTime;

    public function breaks()
    {
        return $this->hasMany(ExclusiveBreak::class);
    }

    public function repeat()
    {
        return $this->belongsTo(Repeat::class);
    }

    public function scopeDay(Builder $query, string $day)
    {
        return $query->where('day', $day);
    }

    public function isWithinSchedule(Carbon $datetime)
    {
        return $datetime->isBetween($this->getStartByDay($datetime), $this->getEndByDay($datetime), true);
    }

    public function isValidWeek(Carbon $for): bool
    {
        $datetime = $for->copy();
        if (!$datetime->isUtc()) {
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

        if (!$this->start_date) {
            return true;
        }

        $start_day = Carbon::parse($this->start_date)->setTimezone('UTC')->startOfDay();

        $weeks_count = $start_day->diffInWeeks($datetime);
        if ($weeks_count == 0 || $weeks_count % $this->repeat->every == 0) {
            return true;
        }

        return false;
    }

    public function getStartByDay(Carbon $day)
    {
        return $this->getDateTimeByDateAndTime($day, Carbon::parse($this->start));
    }
    public function getEndByDay(Carbon $day)
    {
        return $this->getDateTimeByDateAndTime($day, Carbon::parse($this->end));
    }
}
