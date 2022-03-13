<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repeat extends Model
{
    use HasFactory;

    public function scopeEvery($query, $every)
    {
        return $query->where('every', $every);
    }

    public function scopeWeek($query)
    {
        return $query->where('type', 'week');
    }
}
