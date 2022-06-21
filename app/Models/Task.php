<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['is_active', 'task_name', 'task_notes', 'task_url'];

    /**
     * @return HasMany
     */
    public function trackingItems(): HasMany
    {
        return $this->hasMany(TaskTrackingItem::class);
    }
}
