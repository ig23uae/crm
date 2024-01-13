<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandsFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        $carBrands = ['Mitsubishi', 'Toyota', 'Chevrolet', 'Mercedes', 'BMW'];

        return [
            'car_brand' => $this->faker->randomElement($carBrands),
            // Другие поля, если они есть
        ];
    }
}
