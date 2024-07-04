<?php

namespace App\DataFixtures;

use App\Entity\ChatRoom;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ChatRoomFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $i = 0;
        //* create one or two comment for each user in the chatRoom
        foreach (UserFixture::USER_ARRAY as ['ref' => $ref]) {
            $chatRoom = new ChatRoom();
            $date = $faker->dateTime();

            $chatRoom->setContent($faker->text(400))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($date))
                ->setUser($this->getReference($ref))
            ;

            if($i === 0) {
                $chatRoom = new ChatRoom();

                $chatRoom->setContent($faker->text(400))
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable($date->modify('+1 month')))
                    ->setUser($this->getReference($ref))
                ;
            }

            $manager->persist($chatRoom);

            $i++;
        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [UserFixture::class];
    }
}
