<?php
namespace App\DataFixtures;

use App\Entity\CrewMember;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CrewMemberFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        for($i = 0; $i <= 10; $i++){
            $member = new CrewMember();
            $member->setFirstname($faker->firstName)
                ->setLastName($faker->lastName)
                ->setPoste($faker->jobTitle)
            ;
            $manager->persist($member);
        }

        $manager->flush();
    }
}