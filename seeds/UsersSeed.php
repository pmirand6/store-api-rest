<?php
namespace app\seeds;

use app\seeds\Seed;

class UsersSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('users')->columns([
                'id',
                'email' => $this->faker->email(),
            ])->rowQuantity(30);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}