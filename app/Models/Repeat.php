<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Repeat extends Model
{
    use HasFactory;

    public function scopeEvery(Builder $query, $every)
    {
        return $query->where('every', $every);
    }

    public function scopeWeek(Builder $query)
    {
        return $query->where('type', 'week');
    }
}
