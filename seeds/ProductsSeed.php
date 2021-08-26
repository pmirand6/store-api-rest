<?php
namespace app\seeds;

use app\seeds\Seed;

class ProductsSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('products')->columns([
                'id',
                'name' => $this->faker->sentence(3),
                'presentation' => $this->faker->text(),
                'volumes_name' => $this->faker->randomElement(['CM3', 'LT']),
                'volume_value' => $this->faker->biasedNumberBetween(1, 600),
                'weights_name' => $this->faker->randomElement(['KG', 'GR']),
                'weight_value' => $this->faker->biasedNumberBetween(1, 600),
                'requires_cold' => $this->faker->boolean(50),
                'clasification' => $this->faker->biasedNumberBetween(1, 10),
                'stock' => $this->faker->randomNumber(),
                'price' => $this->faker->randomFloat(2),
                'reposition_point' => $this->faker->randomNumber(),
                'delivery_time' => $this->faker->randomNumber(),
                'expires' => $this->faker->boolean(50),
                'expires_time' => $this->faker->numberBetween(1, 180),
                'status' => $this->faker->randomElement(['pendiente', 'habilitado', 'rechazado', 'eliminado']),
                'active' => $this->faker->boolean(80),
                'delivery_types' => "",
                'providers_id' => $this->generator->relation('providers', 'id'),
                'product_types_id' => $this->generator->relation('product_types', 'id'),
                'subproduct_types_id' => $this->generator->relation('subproduct_types', 'id'),
                'subproduct_typifications_id' => $this->generator->relation('subproduct_typifications', 'id'),
            ])->rowQuantity(180);     
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}