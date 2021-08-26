<?php
namespace app\seeds;

use app\seeds\Seed;

class QualificationsSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('qualifications')->columns([
                'id',
                'purchases_id' => $this->generator->relation('purchases', 'id'),
                'liked' => $this->faker->boolean(50),
                'comment' => $this->faker->text(), 
                'title' => $this->faker->sentence(3),
                'product_score' => $this->faker->biasedNumberBetween(0, 5),
                'delivery_score' => $this->faker->biasedNumberBetween(0, 5),
                'provider_score' => $this->faker->biasedNumberBetween(0, 5),
            ])->rowQuantity(600);     
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}