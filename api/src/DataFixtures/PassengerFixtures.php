<?php
namespace App\DataFixtures;

use App\Entity\CrewMember;
use App\Entity\Passenger;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PassengerFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i <= 10; $i++){
            $member = new Passenger();
            $member->setFirstname($faker->firstName)
                ->setLastName($faker->lastName)
                ->setDateBirth($faker->dateTime())
                ->setEmail($faker->email)
                ->setPhone($faker->phoneNumber)
            ;
            $manager->persist($member);
        }

        $manager->flush();
    }
}