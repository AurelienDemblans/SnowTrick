<?php

declare (strict_types=1);

namespace App\Service;

use App\Entity\TrickVideo;
use App\Exception\SnowTrickException;
use DateTimeImmutable;
use Generator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class VideoFactory
{
    private const ALLOWED_EXTENSIONS = ['mp4', 'mkv'];
    private const ALLOWED_MIME_EXTENSIONS = ['video/mp4', 'video/x-matroska'];

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly ParameterBagInterface $params
    ) {
    }

    /**
     * createPictureFromList
     *
     * @param  array $picturesList
     * @return Generator
     */
    public function createVideoFromList(array $picturesList): Generator
    {
        foreach ($picturesList as $picture) {
            yield $this->createVideo($picture);
        }
    }

    /**
     * createPicture
     *
     * @param  UploadedFile $picture
     * @return TrickVideo
     */
    private function createVideo(UploadedFile $video): TrickVideo
    {
        $extension = $video->guessExtension();
        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            throw new SnowTrickException('Le fichier doit être une vidéo.');
        }

        $mimeType = $video->getMimeType();
        if (!in_array($mimeType, self::ALLOWED_MIME_EXTENSIONS)) {
            throw new SnowTrickException('Le fichier doit être une vidéo.');
        }


        $filename = uniqid('video_', true) . '.' . $extension;

        try {
            $trickVideo = new TrickVideo();
            $trickVideo->setUrl($filename);
            $trickVideo->setCreatedAt(new DateTimeImmutable());
        } catch (\Throwable $th) {
            //throw $th;
        }

        $videoDirectory = $this->params->get('videos_directory');
        $video->move(
            $videoDirectory,
            $filename
        );

        return $trickVideo;
    }
}
