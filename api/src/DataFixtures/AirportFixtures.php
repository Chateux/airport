<?php
namespace App\DataFixtures;

use App\Entity\Airport;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AirportFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i <= 10; $i++){
            $member = new Airport();
            $member->setName($faker->name)
                ->setCountry($faker->country)
            ;
            $manager->persist($member);
        }

        $manager->flush();
    }
}