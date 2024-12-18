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
        $finder->files()->in('public\asset\pictures')->name(['*.jpg', '*.jpeg','*.png']);
        foreach ($finder as $file) {
            $fileName = $file->getFilename();
            $pictures[] = $fileName;
        }

        $faker = Factory::create('fr_FR');

        $i = 0;
        foreach (TrickFixture::TRICK_ARRAY as $key => ['ref' => $trick]) {
            $trickPicture = new TrickPicture();
            $date = $faker->dateTime();

            if ($i === 0) {
                $trickPicture->setHomepage(true);
            }

            $trickPicture->setUrl($pictures[0] !== 'snowtrick4.jpg' ? $pictures[0] : $pictures[1])
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($date))
                ->setTrick($this->getReference($trick))
            ;
            array_shift($pictures);
            $i++;
            $manager->persist($trickPicture);
        }

        foreach (TrickFixture::TRICK_ARRAY as $key => ['ref' => $trick]) {
            $trickPicture = new TrickPicture();
            $date = $faker->dateTime();

            $trickPicture->setUrl($pictures[0] !== 'snowtrick4.jpg' ? $pictures[0] : $pictures[1])
            ->setCreatedAt(\DateTimeImmutable::createFromMutable($date))
                ->setTrick($this->getReference($trick))
            ;

            array_shift($pictures);
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
