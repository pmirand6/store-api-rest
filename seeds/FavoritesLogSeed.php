<?php
namespace app\seeds;

use app\seeds\Seed;

class FavoritesLogSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('favorites_log')->columns([
                'log_id' => $this->generator->pk,
                'id' => $this->generator->relation('favorites', 'id'),
                'clients_id',
                'products_id',
            ])->rowQuantity(300);     
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}