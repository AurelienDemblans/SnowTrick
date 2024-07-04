<?php

namespace App\DataFixtures;

use App\Entity\TrickComment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TrickCommentFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        foreach ($this->getTrickAndUserRefs() as ['trickRef' => $trickRef,'userRef' => $userRef]) {
            $trickComment = new TrickComment();
            $date = $faker->dateTime();

            $trickComment->setContent($faker->text($faker->numberBetween(0, 400)))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($date))
                ->setUser($this->getReference($userRef))
                ->setTrick($this->getReference($trickRef))
            ;

            $manager->persist($trickComment);
        }

        for ($i = 0; $i < 15; $i++) {
            $trickComment = new TrickComment();
            $date = $faker->dateTime();

            $trickComment->setContent($faker->text($faker->numberBetween(0, 400)))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($date))
                ->setUser($this->getReference('Nicolas'))
                ->setTrick($this->getReference('Stalefish'))
            ;

            $manager->persist($trickComment);
        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [UserFixture::class, TrickFixture::class];
    }

    private function getTrickAndUserRefs()
    {
        $alltrikcs = TrickFixture::TRICK_ARRAY;
        //* remove last entry array to get one trick without comment
        array_pop($alltrikcs);

        //* remove last entry array to get one user without comment
        $users = UserFixture::USER_ARRAY;
        array_pop($users);

        $tricksRefs = array_map(fn ($trick): string => $trick['ref'], $alltrikcs);
        $usersRefs = array_map(fn ($user): string => $user['ref'], $users);

        $trickAndUserRefs = [];
        for ($i = 0; $i < 20; $i++) {
            $trickAndUserRefs[] = [
                'trickRef' => $tricksRefs[array_rand($tricksRefs)],
                'userRef' => $usersRefs[array_rand($usersRefs)]
            ];
        }

        return $trickAndUserRefs;
    }
}
