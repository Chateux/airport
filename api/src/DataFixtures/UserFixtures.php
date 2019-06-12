<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('fr_FR');
        $role = array("ROLE_ADMIN");

        $mdp = "password";

        for($i = 0; $i <= 10; $i++){
            $user = new User();
            $user->setFirstname($faker->firstName)
                ->setLastName($faker->lastName)
                ->setEmail($faker->email)
                ->setRoles($role)
                ->setPassword($this->encoder->encodePassword($user, $mdp))
                ->setPlainPassword($mdp);
            $manager->persist($user);
        }

        $manager->flush();
    }
}