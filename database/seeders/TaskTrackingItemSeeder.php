<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskTrackingItem;
use Illuminate\Database\Seeder;

class TaskTrackingItemSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Task::all() as $task) {
            TaskTrackingItem::factory(rand(1, 20))->create(['task_id' => $task->id]);
        }
    }
}
