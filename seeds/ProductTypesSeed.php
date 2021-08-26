<?php
namespace app\seeds;

use app\seeds\Seed;

class ProductTypesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('product_types')->columns([
                'id',
                'name' => $this->faker->sentence(3),
                'active' => $this->faker->boolean(80),
            ])->rowQuantity(30);
            
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}