<?php

namespace App\DataFixtures;

use App\Entity\TrickGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TrickGroupFixture extends Fixture
{
    public const TRICK_GROUP_ARRAY = [
        ['name' => 'Grabs', 'ref' => 'Grabs'],
        ['name' => 'Rotations', 'ref' => 'Rotations'],
        ['name' => 'Flips', 'ref' => 'Flips'],
        ['name' => 'Slides', 'ref' => 'Slides'],
        ['name' => 'One foot', 'ref' => 'One foot' ],
        ['name' => 'Old school', 'ref' => 'Old school'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::TRICK_GROUP_ARRAY as ['name' => $groupName, 'ref' => $ref]) {
            $trickGroup = new TrickGroup();
            $trickGroup->setName($groupName);

            $manager->persist($trickGroup);

            $this->addReference($ref, $trickGroup);
        }

        $manager->flush();
    }
}
