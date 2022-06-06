<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Task;
use App\Models\TaskTrackingTime;
use Illuminate\Database\Seeder;

class TaskTrackingTimeSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Task::all() as $task) {
            TaskTrackingTime::factory(rand(1, 20))->create(['task_id' => $task->id]);
        }
    }
}
