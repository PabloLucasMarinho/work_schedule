<?php

namespace Database\Factories;

use App\Enums\Frequency;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startsAt = now();

        return [
            'user_id' => 1,
            'starts_at' => $startsAt,
            'ends_at' => $startsAt->copy()->addDays(fake()->numberBetween(1, 365)),
            'frequency' => fake()->randomElement(Frequency::cases()),
        ];
    }
}
