<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = User::query()->where('email', config('app.seeder.admin_user_email'))->first();

        Task::factory(20)->create(['user_id' => $adminUser]);
        Task::factory(100)->create();
    }
}
