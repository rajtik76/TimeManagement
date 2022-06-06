<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class TaskTrackingTimeFactory extends Factory
{
    public function definition(): array
    {
        $date = $this->faker->dateTimeThisYear();
        $timestamp = $this->faker->dateTimeThisYear();

        return [
            'task_id' => Task::factory(),
            'record_date' => $date,
            'spent_time' => $this->faker->randomFloat(1, 1, 8),
            'note' => $this->faker->sentence,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];
    }
}
