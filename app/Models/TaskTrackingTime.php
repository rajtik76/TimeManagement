<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTrackingTime extends Model
{
    use HasFactory;

    protected $casts = [
        'record_date' => 'date',
    ];
}
