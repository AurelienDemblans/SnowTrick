<?php

declare (strict_types=1);

namespace App\Service\Factory;

use App\Entity\TrickPicture;
use App\Exception\FormException;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Generator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureFactory
{
    private const ALLOWED_EXTENSIONS = ['jpg', 'jpeg', 'png', 'gif'];
    private const ALLOWED_MIME_EXTENSIONS = ['image/jpeg', 'image/png', 'image/gif'];

    public function __construct(
        private readonly ParameterBagInterface $paramsBagInterface,
        private readonly Filesystem $filesystem
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
    public function createPicture(UploadedFile $picture, bool $isCover = false): TrickPicture
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

        $trickPicture = new TrickPicture();
        $trickPicture->setUrl($filename);
        $trickPicture->setCreatedAt(new DateTimeImmutable());
        if ($isCover) {
            $trickPicture->setMainPicture(true);
        }

        $picturesDirectory = $this->paramsBagInterface->get('pictures_directory');
        $picture->move(
            $picturesDirectory,
            $filename
        );

        return $trickPicture;
    }

    /**
     * deletePicture
     *
     * @param  ArrayCollection $pictureArray
     *
     * @return void
     */
    public function removePicturesFromDirectory(?ArrayCollection $pictureArray): void
    {
        if (null === $pictureArray) {
            return;
        }

        $pictureDirectoryPath = $this->paramsBagInterface->get('pictures_directory');

        $picturesFilePath = [];
        foreach ($pictureArray as $picture) {
            $picturesFilePath[] = $pictureDirectoryPath.'\\'.$picture->getUrl();
        }

        $this->filesystem->remove($picturesFilePath);
    }
}
