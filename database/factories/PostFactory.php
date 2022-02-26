<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_number' =>'3753338',
            'category' =>$this->faker->text(15),
            'title' => $this->faker->text(15),
            'county' =>$this->faker->text(15),
            'sub_county' => $this->faker->text(15),
            'location' => $this->faker->address(),
            'price_from' =>$this->faker->numberBetween(50,2000),
            'price_to' =>$this->faker->numberBetween(2000,7000),
            'email' =>$this->faker->email(),
            'phone' =>$this->faker->phoneNumber(),
            'description' => $this->faker->text('500'),
            'sponsorship' => $this->faker->numberBetween(50,1000),
            'created_at' =>$this->faker->dateTime(),
            'updated_at' => $this->faker->dateTime(),
        ];
    }
}
