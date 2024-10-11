<?php

declare (strict_types=1);

namespace App\Service;

use App\Entity\Trick;
use App\Exception\SnowTrickException;
use App\Repository\TrickRepository;
use DateTimeImmutable;
use Generator;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TrickAddFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly TrickRepository $trickRepository,
        private readonly PictureFactory $pictureFactory
    ) {

    }

    /**
     * createTrick
     *
     * @param  Trick $trick
     * @param  Generator $trickPictures
     * @param  Generator $trickVideos
     *
     * @return Trick
     */
    public function createTrick(Trick $trick, Generator $trickPictures, Generator $trickVideos): Trick
    {
        $slugGenerator = new SlugGenerator();

        if ($this->trickRepository->findOneByName($trick->getName()) !== null) {
            throw new SnowTrickException('impossible de créer le trick : ce nom est déjà utilisé');
        }

        $trick->setCreatedAt(new DateTimeImmutable());
        $trick->setUpdatedAt(null);
        $trick->setSlug($slugGenerator($trick->getName()));
        foreach ($trickPictures as $trickPicture) {
            $trick->addTrickPicture($trickPicture);
        }
        foreach ($trickVideos as $trickVideo) {
            $trick->addTrickVideo($trickVideo);
        }

        return $trick;
    }
}
