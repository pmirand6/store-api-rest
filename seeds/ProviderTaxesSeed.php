<?php
namespace app\seeds;

use app\seeds\Seed;

class ProviderTaxesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('provider_taxes')->columns([
                'id',
                'cuit' => $this->faker->numerify('###########'),
                'number' => $this->faker->numerify('######'),
                'qualification' => $this->faker->text(30),
                'qualification_notes' => $this->faker->text(100),
                'active' => $this->faker->boolean(80),
                'providers_id',
            ])->rowQuantity(30);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}