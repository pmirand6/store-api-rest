<?php
namespace app\seeds;

use tebazil\yii2seeder\Seeder;

abstract class Seed
{
    protected $seeder;
    protected $faker;
    protected $generator;

    function __construct(Seeder $seeder)
    {
        $this->seeder = $seeder;
        $this->generator = $this->seeder->getGeneratorConfigurator();
        $this->faker = $this->generator->getFakerConfigurator();
    }
}