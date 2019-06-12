<?php
namespace App\DataFixtures;

use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class ModelFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i <= 10; $i++){
            $model = new Model();
            $model->setReference($faker->name)
                ->setBrand($faker->company)
                ->setLength($faker->randomFloat(2, 0, 10))
                ->setSeat($faker->numberBetween(0, 500))
                ->setWeight($faker->numberBetween(100, 200))
                ->setWidth($faker->numberBetween(0, 500))
            ;
            $manager->persist($model);
        }

        $manager->flush();
    }
}