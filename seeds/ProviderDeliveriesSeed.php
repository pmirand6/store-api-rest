<?php
namespace app\seeds;

use app\seeds\Seed;

class ProviderDeliveriesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('provider_deliveries')->columns([
                'id',
                'time_from' => $this->faker->time(),
                'time_to' => $this->faker->time(),
                'day' => $this->faker->randomElement(['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom']),
                'providers_id',
            ])->rowQuantity(30);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}