<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyHour extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'weekly_hours';
    protected $fillable = ['emp_id', 'date', 'hours'];

    protected $casts = [
        'date' => 'date',
        'hours' => 'datetime:H:i',
    ];
}
