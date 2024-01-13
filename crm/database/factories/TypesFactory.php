<?php

namespace Database\Factories;

use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypesFactory extends Factory
{
    protected $model = Type::class;

    public function definition()
    {
        $carTypes = ['Внедорожник', 'Седан', 'Хэтчбек', 'Купе', 'Универсал', 'Минивэн'];

        return [
            'car_type' => $this->faker->randomElement($carTypes),
            // Другие поля, если они есть
        ];
    }
}
