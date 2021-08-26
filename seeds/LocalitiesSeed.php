<?php
namespace app\seeds;

use app\seeds\Seed;

class LocalitiesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('countries')->columns([
                'id',
                'country' => 'Argentina',
            ])->rowQuantity(1);

            $this->seeder->table('provinces')->columns([
                'id',
                'countries_id',
                'province' => 'Neuquen',
            ])->rowQuantity(1);

            $this->seeder->table('localities')->columns([
                'id',
                'provinces_id',
                'locality' => 'Zona Norte',
            ])->rowQuantity(1);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}