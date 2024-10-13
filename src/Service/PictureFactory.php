<?php

declare (strict_types=1);

namespace App\Service;

use App\Entity\TrickPicture;
use App\Exception\FormException;
use App\Repository\TrickRepository;
use DateTimeImmutable;
use Generator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PictureFactory
{
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif'];
    private const ALLOWED_MIME_EXTENSIONS = ['image/jpeg', 'image/png', 'image/gif'];

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly TrickRepository $trickRepository,
        private readonly ParameterBagInterface $paramsBagInterface
    ) {
    }

    /**
     * createPictureFromList
     *
     * @param  array $picturesList
     * @return Generator
     */
    public function createPictureFromList(array $picturesList): Generator
    {
        foreach ($picturesList as $picture) {
            yield $this->createPicture($picture);
        }
    }

    /**
     * createPicture
     *
     * @param  UploadedFile $picture
     * @return TrickPicture
     */
    private function createPicture(UploadedFile $picture): TrickPicture
    {
        $extension = $picture->guessExtension();
        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            throw new FormException('Le fichier doit être une image.');
        }

        $mimeType = $picture->getMimeType();
        if (!in_array($mimeType, self::ALLOWED_MIME_EXTENSIONS)) {
            throw new FormException('Le fichier doit être une image.');
        }


        $filename = uniqid('img_', true) . '.' . $extension;

        try {
            $trickPicture = new TrickPicture();
            $trickPicture->setUrl($filename);
            $trickPicture->setCreatedAt(new DateTimeImmutable());
        } catch (\Throwable $th) {
            //throw $th;
        }

        $picturesDirectory = $this->paramsBagInterface->get('pictures_directory');
        $picture->move(
            $picturesDirectory,
            $filename
        );

        return $trickPicture;
    }
}
