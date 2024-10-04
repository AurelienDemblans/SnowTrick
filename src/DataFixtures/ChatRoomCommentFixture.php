<?php

namespace App\DataFixtures;

use App\Entity\ChatRoomComment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ChatRoomCommentFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $i = 0;
        //* create one or two chat room comment for each user
        foreach (UserFixture::USER_ARRAY as ['ref' => $ref]) {
            $chatRoomComment = new ChatRoomComment();
            $date = $faker->dateTime();

            $chatRoomComment->setContent($faker->text(400))
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($date))
                ->setUser($this->getReference($ref))
            ;

            if ($i === 0) {
                $chatRoomComment = new ChatRoomComment();

                $chatRoomComment->setContent($faker->text(400))
                    ->setCreatedAt(\DateTimeImmutable::createFromMutable($date->modify('+1 month')))
                    ->setUser($this->getReference($ref))
                ;
            }

            $manager->persist($chatRoomComment);

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
