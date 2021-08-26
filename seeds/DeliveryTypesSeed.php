<?php
namespace app\seeds;

use app\seeds\Seed;

class DeliveryTypesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('delivery_types')->data([
                [ 1, 'delivery' ],
                [ 2, 'node' ],
                [ 3, 'takeaway' ]
            ], [ false, 'delivery_type' ])->rowQuantity(3);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}