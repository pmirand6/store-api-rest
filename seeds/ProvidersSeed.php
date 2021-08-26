<?php
namespace app\seeds;

use app\seeds\Seed;

class ProvidersSeed extends Seed
{
    public function seed(): void
    {
        try {
            $this->seeder->table('providers')->columns([
                'id',
                'users_id',
                'provider_types_id' => $this->generator->relation('provider_types', 'id'), 
                'name' => $this->faker->name(),
                'business_name' => $this->faker->company(),
                'clasification' => $this->faker->biasedNumberBetween(0, 5),
                'latitude' => $this->faker->latitude(-38, -39),
                'longitude' => $this->faker->latitude(-68, -69),
                'floor' => $this->faker->biasedNumberBetween(0, 15),
                'training' => $this->faker->boolean(70),
                'logo' => $this->faker->imageUrl(640, 480),
                'phone_number' => $this->faker->numerify('##########'),
                'email' => $this->faker->email(),
                'participate_fairs' => $this->faker->boolean(70),
                'signature' => false,
                'signature_date' => null,
                'active' => $this->faker->boolean(90),
                'locality' => $this->faker->locality(),
                'address' => $this->faker->address(),
                'street_number' => $this->faker->randomNumber(),
                'city' => $this->faker->city(),
                'province' => $this->faker->province(),
                'country' => $this->faker->country(),
                'formatted_address' => $this->faker->streetName(),
            ])->rowQuantity(30);
        } catch (\Throwable $th) {
            var_dump($th->getMessage());
        }
    }
}