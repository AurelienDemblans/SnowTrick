<?php

namespace App\DataFixtures;

use App\Entity\TrickVideo;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Finder\Finder;

class TrickVideoFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $finder = new Finder();

        $videos = [];
        $finder->files()->in('public\asset\videos')->name(['*.mp4']);
        foreach ($finder as $file) {
            $fileName = $file->getFilename();
            $videos[] = $fileName;
        }

        $faker = Factory::create('fr_FR');

        $trickVideo = new TrickVideo();
        $date = $faker->dateTime();

        $trickVideo->setUrl($videos[array_rand($videos)])
        ->setCreatedAt(\DateTimeImmutable::createFromMutable($date))
            ->addTrick($this->getReference('Stalefish'))
        ;

        $manager->persist($trickVideo);

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
