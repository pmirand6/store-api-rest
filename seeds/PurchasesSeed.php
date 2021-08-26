<?php
namespace app\seeds;

use app\seeds\Seed;

class PurchasesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('purchases')->columns([
                'id',
                'clients_id' => $this->generator->relation('clients', 'id'),
                'products_id' => $this->generator->relation('products', 'id'),
                'delivery_types_id' => $this->faker->randomElement([1, 2, 3]),
                'addresses_id' => $this->generator->relation('addresses', 'id'),
                'quantity' => $this->faker->randomNumber(2),
                'delivery_cost' => $this->faker->randomFloat(2),
                'service_cost' => $this->faker->randomFloat(2),
                'purchase_code' => $this->faker->asciify('******'),
                'shipping_code' => $this->faker->asciify('******'),
            ])->rowQuantity(500);     
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}