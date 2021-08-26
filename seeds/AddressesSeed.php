<?php
namespace app\seeds;

use app\seeds\Seed;

class AddressesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('addresses')->columns([
                'id',
                'street' => $this->faker->streetName(),
                'number' => $this->faker->buildingNumber(),
                'floor' => $this->faker->randomDigit(),
                'apartment' => $this->faker->randomLetter(),
                'zip_code' => $this->faker->postcode(),
                'countries_id',
                'provinces_id',
                'localities_id',
                'latitude' => $this->faker->latitude(-38, -39),
                'longitude' => $this->faker->latitude(-68, -69),
                'clients_id',
            ])->rowQuantity(300);     
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}