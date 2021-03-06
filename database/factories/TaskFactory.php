<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Customer;
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
        $timestamp = $this->faker->dateTimeThisDecade;

        return [
            'customer_id' => Customer::factory(),
            'user_id' => User::factory(),
            'is_active' => true,
            'task_name' => $this->faker->unique()->sentence(),
            'task_notes' => $this->faker->paragraph(1),
            'task_url' => $this->faker->url(),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];
    }
}
