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

class FlightFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $airport = $manager->getRepository(Airport::class)->findAll();
        $passengers = $manager->getRepository(Passenger::class)->findAll();

        for($i = 0; $i <= 10; $i++){
            $flight = new Flight();
            $flight->setReference($faker->name)
                ->setAirport($airport[array_rand($airport)])
                ->setArrivalDate($faker->dateTime())
                ->setDepatureDate($faker->dateTime())
                ->setAirportDeparture($airport[array_rand($airport)])
                ->setAirportDestination($airport[array_rand($airport)])
                ->addPassenger($passengers[array_rand($passengers)]);
            ;

            $manager->persist($flight);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PassengerFixtures::class,
            AirportFixtures::class,
            CrewMemberFixtures::class
        ];
    }
}