<?php

namespace Database\Factories;

use App\Models\Instituto;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstitutoFactory extends Factory
{
    protected $model = Instituto::class;

    public function definition()
    {
        return [
			'RUC' => $this->faker->name,
			'Nombre' => $this->faker->name,
			'Cuenta_Corriente' => $this->faker->name,
        ];
    }
}
