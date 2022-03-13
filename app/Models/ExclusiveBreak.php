<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

// Using Exclusive break as break itself is a reserve word
class ExclusiveBreak extends Model
{
    use HasFactory;

    public function isWithinBreak(Carbon $time)
    {
        return $time->isBetween($this->start, $this->end, true);
    }
}
