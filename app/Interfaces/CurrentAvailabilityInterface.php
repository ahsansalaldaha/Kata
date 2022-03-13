<?php

namespace App\Interfaces;

interface CurrentAvailabilityInterface
{
    public function isOpen(): bool;
}
