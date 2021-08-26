<?php
namespace app\seeds;

use app\seeds\Seed;

class ClientsSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('clients')->columns([
                'id',
                'active' => $this->faker->boolean(80),
                'gender' => $this->faker->randomElement(['M', 'F']),
                'dni' => $this->faker->numerify('########'),
                'signature' => $this->faker->boolean(50),
                'signature_date' => $this->faker->date(),
                'contracts_id',
                'users_id',
                'name' => $this->faker->name(),
            ])->rowQuantity(20);     
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}