<?php
namespace app\seeds;

use app\seeds\Seed;

class ProductImagesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('product_images')->columns([
                'id',
                'image' => $this->faker->imageUrl(640, 480),
                'products_id',
            ])->rowQuantity(300);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}