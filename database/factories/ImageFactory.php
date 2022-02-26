<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
          'post_id' =>'6',
            'url' =>'https://source.unsplash.com/random',
            'updated_at' =>$this->faker->dateTime(),
            'created_at' =>$this->faker->dateTime()
        ];
    }
}
