<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['is_active', 'task_name', 'task_notes', 'task_url'];

    public function trackingItems()
    {
        return $this->hasMany(TaskTrackingItem::class);
    }
}
