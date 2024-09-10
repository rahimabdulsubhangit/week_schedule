<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class team extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'team';

    public function employees()
    {
        return $this->hasMany(emp::class);
    }
}
