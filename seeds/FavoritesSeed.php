<?php
namespace app\seeds;

use app\seeds\Seed;

class FavoritesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('favorites')->columns([
                'id',
                'clients_id',
                'products_id',
            ])->rowQuantity(300);     
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}