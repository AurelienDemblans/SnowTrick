<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class UserFixture extends Fixture
{
    public const USER_ARRAY = [
        ['name' => 'John','role' => 'Admin', 'ref' => 'John'],
        ['name' => 'Pierre','role' => 'Admin', 'ref' => 'Pierre'],
        ['name' => 'Marcel','role' => 'Subscriber', 'ref' => 'Marcel'],
        ['name' => 'Hugo','role' => 'Subscriber', 'ref' => 'Hugo'],
        ['name' => 'Nicolas','role' => 'Moderator', 'ref' => 'Nicolas' ],
        ['name' => 'Frédéric','role' => 'Moderator', 'ref' => 'Frédéric'],
        ['name' => 'Emmanuel','role' => 'Subscriber', 'ref' => 'Emmanuel'],
        ['name' => 'Valentin','role' => 'Subscriber', 'ref' => 'Valentin'],
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (self::USER_ARRAY as ['name' => $name,'role' => $role, 'ref' => $ref]) {
            $user = new User();

            $user->setName($name)
                ->setPassword($faker->password())
                ->setEmail($faker->safeEmail())
                ->setRole($role)
            ;

            if($name === 'Hugo' || $name === 'John') {
                $user->setLogo('https://picsum.photos/200');
            }

            $manager->persist($user);

            $this->addReference($ref, $user);
        }

        $manager->flush();
    }
}
