<?php

namespace Database\Factories;

use App\Models\TodoPriority;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoPriorityFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TodoPriority::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
