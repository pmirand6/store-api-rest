<?php
namespace app\seeds;

use app\seeds\Seed;

class ProviderTypesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('provider_types')->columns([
                'id',
                'description' => 'Productor',
            ])->rowQuantity(1);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}