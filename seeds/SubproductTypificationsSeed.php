<?php
namespace app\seeds;

use app\seeds\Seed;

class SubproductTypificationsSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('subproduct_typifications')->columns([
                'id',
                'name' => $this->faker->sentence(3),
                'active' => $this->faker->boolean(80),
                'subproduct_types_id' => $this->generator->relation('subproduct_types', 'id'),
            ])->rowQuantity(30);
            
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}