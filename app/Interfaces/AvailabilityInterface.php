<?php

namespace App\Interfaces;

use Illuminate\Support\Carbon;

use App\Models\Schedule;

interface AvailabilityInterface
{
    public function isOpenOn(Carbon $date): bool;
}
