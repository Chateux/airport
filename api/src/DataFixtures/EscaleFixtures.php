<?php

namespace App\DataFixtures;

use App\Entity\Airport;
use App\Entity\CrewMember;
use App\Entity\Escale;
use App\Entity\Flight;
use App\Entity\Passenger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class EscaleFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $airport = $manager->getRepository(Airport::class)->findAll();
        $passenger = $manager->getRepository(Passenger::class)->findAll();
        $escale = $manager->getRepository(Escale::class)->findAll();
        $member = $manager->getRepository(CrewMember::class)->findAll();

        for($i = 0; $i <= 10; $i++){
            $escale = new Escale();
            $escale->setReference($faker->name)
                ->setArrivalDate($faker->dateTime())
                ->setDepartureDate($faker->dateTime())
                ->addPassenger($passenger[array_rand($passenger)])
                ->setAirportDeparture($airport[array_rand($airport)])
                ->setAirportDestination($airport[array_rand($airport)])
            ;
            $manager->persist($escale);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PassengerFixtures::class,
            AirportFixtures::class,
            FlightFixtures::class
        ];
    }
}