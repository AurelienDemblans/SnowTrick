<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture
{
    public const USER_ARRAY = [
        ['name' => 'John','role' => 'Admin', 'ref' => 'John', 'email' => 'John@example.com', 'logo' => !null],
        ['name' => 'Pierre','role' => 'Admin', 'ref' => 'Pierre', 'email' => 'Pierre@example.com', 'logo' => !null],
        ['name' => 'Marcel','role' => 'Subscriber', 'ref' => 'Marcel', 'email' => 'Marcel@example.com', 'logo' => null],
        ['name' => 'Hugo','role' => 'Subscriber', 'ref' => 'Hugo', 'email' => 'Hugo@example.com', 'logo' => !null],
        ['name' => 'Nicolas','role' => 'Moderator', 'ref' => 'Nicolas' , 'email' => 'Nicolas@example.com', 'logo' => null],
        ['name' => 'Frédéric','role' => 'Moderator', 'ref' => 'Frédéric', 'email' => 'Frédéric@example.com', 'logo' => null],
        ['name' => 'Emmanuel','role' => 'Subscriber', 'ref' => 'Emmanuel', 'email' => 'Emmanuel@example.com', 'logo' => null],
        ['name' => 'Valentin','role' => 'Subscriber', 'ref' => 'Valentin', 'email' => 'Valentin@example.com', 'logo' => null],
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (self::USER_ARRAY as ['name' => $name,'role' => $role, 'ref' => $ref, 'email' => $email, 'logo' => $logo]) {
            $user = new User();

            $user->setName($name)
                ->setPassword($faker->password())
                ->setEmail($email)
                ->setRoles([$role])
            ;

            if ($logo) {
                $user->setLogo('https://picsum.photos/200');
            }

            $manager->persist($user);

            $this->addReference($ref, $user);
        }

        $manager->flush();
    }
}
