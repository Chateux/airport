<?php
namespace App\DataFixtures;

use App\Entity\Flight;
use App\Entity\Model;
use App\Entity\Plane;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class PlaneFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');

        $flight = $manager->getRepository(Flight::class)->findAll();
        $model = $manager->getRepository(Model::class)->findAll();

        for($i = 0; $i <= 10; $i++){
            $plane = new Plane();
            $plane->setReference($faker->postcode)
                ->setFlight($flight[array_rand($flight)])
                ->setModel($model[array_rand($model)])
            ;
            $manager->persist($plane);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            FlightFixtures::class
        ];
    }
}