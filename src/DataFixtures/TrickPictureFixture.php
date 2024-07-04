<?php

namespace App\DataFixtures;

use App\Entity\TrickPicture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Finder\Finder;

class TrickPictureFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $finder = new Finder();

        $pictures = [];
        $finder->files()->in('public\pictures')->name(['*.jpg', '*.jpeg','*.png']);
        foreach ($finder as $file) {
            $filePath = $file->getPathname();
            $pictures[] = $filePath;
        }

        $faker = Factory::create('fr_FR');

        foreach (TrickFixture::TRICK_ARRAY as ['ref' => $trick]) {
            $trickPicture = new TrickPicture();
            $date = $faker->dateTime();

            $trickPicture->setUrl($pictures[array_rand($pictures)])
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($date))
                ->addTrick($this->getReference($trick))
            ;

            $manager->persist($trickPicture);
        }

        $manager->flush();
    }

    /**
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [TrickFixture::class];
    }
}
