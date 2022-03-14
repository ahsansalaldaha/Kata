<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use App\Models\Traits\DateTimeByDayAndTime;

// Using Exclusive break as break itself is a reserve word
class ExclusiveBreak extends Model
{
    use DateTimeByDayAndTime;
    use HasFactory;

    public function isWithinBreak(Carbon $datetime)
    {
        return $datetime->isBetween($this->getStartByDay($datetime), $this->getEndByDay($datetime), true);
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
