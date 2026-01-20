<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

final class QuoteFactory extends Factory
{
    public function definition(): array
    {
        $total = $this->faker->randomFloat(2, 500, 15000);

        return [
            'user_id' => User::factory(), // Cria um user se não passado
            'client_name' => $this->faker->company(),
            'client_email' => $this->faker->companyEmail(),
            'title' => $this->faker->sentence(3),
            'status' => $this->faker->randomElement(['draft', 'sent', 'approved', 'rejected']),
            'total' => $total,
            'subtotal' => $total,
            'valid_until' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'created_at' => $this->faker->dateTimeBetween('-3 months', 'now'),
        ];
    }
}
