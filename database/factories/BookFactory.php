<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text(25),
            'content' => $this->faker->text(1000),
            'author_id' => rand(1,10),
            'price' => $this->faker->randomDigit,
            'cover' => $this->faker->imageUrl($width = 200, $height = 200),
            'year_published' => $this->faker->date('Y'),
        ];
    }
}
