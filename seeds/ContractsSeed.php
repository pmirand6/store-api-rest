<?php
namespace app\seeds;

use app\seeds\Seed;

class ContractsSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('contracts')->columns([
                'id',
                'type' => $this->faker->randomElement([1, 2]),
                'contract' => $this->faker->text(),
            ])->rowQuantity(4);     
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}