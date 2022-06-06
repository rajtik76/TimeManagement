<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'is_active' => true,
            'task_name' => $this->faker->unique()->sentence(),
            'task_notes' => $this->faker->paragraph(1),
            'task_url' => $this->faker->url(),
        ];
    }
}
