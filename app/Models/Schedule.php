<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
