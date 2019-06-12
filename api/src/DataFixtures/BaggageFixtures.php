<?php

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\Baggage;
use App\Entity\CrewMember;
use App\Entity\Escale;
use App\Entity\Flight;
use App\Entity\Passenger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class BaggageFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i <= 10; $i++){
            $baggage = new Baggage();
            $baggage
                ->setWeight($faker->numberBetween(0, 30))
            ;
            $manager->persist($baggage);
        }

        $manager->flush();
    }
}