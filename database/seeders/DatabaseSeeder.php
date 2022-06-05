<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $adminUserName = config('app.seeder.admin_user_name');
        $adminUserEmail = config('app.seeder.admin_user_email');

        if (User::query()->where('email', $adminUserEmail)->doesntExist()) {
            User::factory()->create([
                'name' => $adminUserName,
                'email' => $adminUserEmail,
            ]);
        }
    }
}
