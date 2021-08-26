<?php
namespace app\seeds;

use app\seeds\Seed;

class QualificationVotesSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('qualification_votes')->columns([
                'id',
                'qualifications_id' => $this->generator->relation('qualifications', 'id'),
                'clients_id' => $this->generator->relation('clients', 'id'),
                'liked' => $this->faker->boolean(50),
            ])->rowQuantity(500);     
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}