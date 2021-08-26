<?php
namespace app\seeds;

use app\seeds\Seed;

class ProviderSignatureHistorySeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('provider_signature_history')->columns([
                'id',
                'ip' => $this->faker->ipv4(),
                'user_agent' => $this->faker->userAgent(),
                'providers_id',
            ])->rowQuantity(90);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}