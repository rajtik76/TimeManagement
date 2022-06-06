<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        foreach (User::all() as $user) {
            Task::factory(rand(10, 50))->create(['user_id' => $user->id]);
        }
    }
}
