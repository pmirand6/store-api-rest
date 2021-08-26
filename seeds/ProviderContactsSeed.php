<?php
namespace app\seeds;

use app\seeds\Seed;

class ProviderContactsSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('provider_contacts')->columns([
                'id',
                'firstname' => $this->faker->firstName(),
                'lastname' => $this->faker->lastName(),
                'dni' => $this->faker->numerify('########'),
                'birthday_date' => $this->faker->date(),
                'responsable' => $this->faker->boolean(50),
                'email' => $this->faker->email(),
                'phone_number' => $this->faker->numerify('##########'),
                'providers_id',
            ])->rowQuantity(30);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}