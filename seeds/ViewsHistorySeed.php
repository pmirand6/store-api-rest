<?php
namespace app\seeds;

use app\seeds\Seed;

class ViewsHistorySeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('views_history')->columns([
                'id',
                'clients_id',
                'products_id',
            ])->rowQuantity(1000);     
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}