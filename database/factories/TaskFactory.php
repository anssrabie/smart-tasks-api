<?php

namespace Database\Factories;

use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $owner = User::inRandomOrder()->first() ?? User::factory()->create();
        $status = Status::inRandomOrder()->first() ?? Status::factory()->create();

        $assignedTo = null;
        if ($this->faker->boolean()) {
            $assignedTo = User::inRandomOrder()->where('id','!=',$owner->id)->first()?->id ?? User::factory()->create()->id;
        }

        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'status_id' => $status->id,
            'owner_id' =>$owner->id,
            'assigned_to' => $assignedTo,
        ];
    }
}
