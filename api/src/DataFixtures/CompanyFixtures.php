<?php
namespace App\DataFixtures;

use App\Entity\Company;
use App\Entity\Plane;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class CompanyFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $plane = $manager->getRepository(Plane::class)->findAll();

        for($i = 0; $i <= 10; $i++){
            $member = new Company();
            $member->setName($faker->company)
                ->setCountry($faker->country)
                ->setPlane($plane[array_rand($plane)])
            ;
            $manager->persist($member);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PlaneFixtures::class,
        ];
    }
}