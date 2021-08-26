<?php
namespace app\seeds;

use app\seeds\Seed;

class SubproductTypesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('subproduct_types')->columns([
                'id',
                'name' => $this->faker->sentence(3),
                'active' => $this->faker->boolean(80),
                'product_types_id' => $this->generator->relation('product_types', 'id'),
            ])->rowQuantity(30);
            
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}