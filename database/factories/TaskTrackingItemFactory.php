<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory
 */
class TaskTrackingItemFactory extends Factory
{
    public function definition(): array
    {
        $date = $this->faker->dateTimeThisYear();
        $timestamp = $this->faker->dateTimeThisYear();

        return [
            'task_id' => Task::factory(),
            'item_date' => $date,
            'item_hours' => $this->faker->randomFloat(1, 1, 8),
            'item_note' => $this->faker->sentence,
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];
    }
}
