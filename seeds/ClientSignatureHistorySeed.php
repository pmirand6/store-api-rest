<?php
namespace app\seeds;

use app\seeds\Seed;

class ClientSignatureHistorySeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('client_signature_history')->columns([
                'id',
                'ip' => $this->faker->ipv4(),
                'user_agent' => $this->faker->userAgent(),
                'clients_id',
            ])->rowQuantity(90);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}