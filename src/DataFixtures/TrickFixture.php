<?php

namespace App\DataFixtures;

use App\Entity\Trick;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TrickFixture extends Fixture implements DependentFixtureInterface
{
    public const TRICK_ARRAY = [
        ['name' => 'Stalefish','group' => 'Grabs', 'ref' => 'Stalefish'],
        ['name' => 'Truck driver','group' => 'Grabs', 'ref' => 'Truck driver'],
        ['name' => '360','group' => 'Rotations', 'ref' => '360'],
        ['name' => '720','group' => 'Rotations', 'ref' => '720'],
        ['name' => 'Front flips','group' => 'Flips', 'ref' => 'Front flips' ],
        ['name' => 'Back flips','group' => 'Flips', 'ref' => 'Back flips'],
        ['name' => 'Tail slide','group' => 'Slides', 'ref' => 'Tail slide'],
        ['name' => 'Japan air','group' => 'Old school', 'ref' => 'Japan air'],
        ['name' => 'Rocket air','group' => 'Old school', 'ref' => 'Rocket air'],
        ['name' => 'Backside Air', 'group' => 'Old school','ref' => 'Backside Air'],
    ];

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach (self::TRICK_ARRAY as ['name' => $name,'group' => $group, 'ref' => $ref]) {
            $trick = new Trick();
            $date = $faker->dateTime();

            $trick->setName($name)
                ->setDescription($faker->text())
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($date))
                ->setTrickGroup($this->getReference($group))
            ;

            if($name === 'Stalefish') {
                $updatedAt = $date->modify('+1 month');
                $trick->setUpdatedAt(\DateTimeImmutable::createFromMutable($updatedAt));
            }

            $manager->persist($trick);

            $this->addReference($ref, $trick);
        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [TrickGroupFixture::class];
    }
}
