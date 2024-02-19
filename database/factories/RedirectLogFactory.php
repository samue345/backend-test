<?php

namespace Database\Factories;

use App\Models\Redirect;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RedirectLog>
 */
class RedirectLogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'redirect_id' => Redirect::factory(),
            'ip_request' => fake()->ipv4,
            'user_agent' => fake()->userAgent,
            'header_refer' => fake()->url,
            'date_access' => $this->faker->dateTime,

        ];
    }
}
