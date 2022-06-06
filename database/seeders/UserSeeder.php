<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminUserName = config('app.seeder.admin_user_name');
        $adminUserEmail = config('app.seeder.admin_user_email');

        if (User::query()->where('email', $adminUserEmail)->doesntExist()) {
            User::factory()->create([
                'name' => $adminUserName,
                'email' => $adminUserEmail,
            ]);
        }

        User::factory(rand(1, 5))->create();
    }
}
