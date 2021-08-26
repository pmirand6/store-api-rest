<?php
namespace app\seeds;

use app\seeds\Seed;

class ProductsHasDeliveryTypesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('products_has_delivery_types')->columns([
                'id',
                'products_id' => $this->generator->relation('products', 'id'),
                'delivery_types_id' => $this->faker->randomElement([1, 2, 3]),
            ])->rowQuantity(600);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}