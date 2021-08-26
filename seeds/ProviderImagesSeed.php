<?php
namespace app\seeds;

use app\seeds\Seed;

class ProviderImagesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('provider_images')->columns([
                'id',
                'image' => $this->faker->imageUrl(640, 480),
                'providers_id',
            ])->rowQuantity(90);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}