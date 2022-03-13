<?php

namespace App\Interfaces;

use Illuminate\Support\Carbon;

interface NextAvailabilityInterface
{
    public function nextAvailability(): ?Carbon;
}
