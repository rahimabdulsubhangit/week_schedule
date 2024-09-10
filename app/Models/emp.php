<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class emp extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'emp';


    public function team()
    {
        return $this->belongsTo(team::class);
    }

    public function weeklyHours()
    {
        return $this->hasMany(WeeklyHour::class);
    }
}
