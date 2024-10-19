<?php

declare (strict_types=1);

namespace App\Service\Factory;

use App\Entity\TrickVideo;
use App\Exception\FormException;
use App\Repository\TrickVideoRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Generator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class VideoFactory
{
    private const ALLOWED_EXTENSIONS = ['mp4', 'mkv'];
    private const ALLOWED_MIME_EXTENSIONS = ['video/mp4', 'video/x-matroska'];
    private const ALLOWED_DOMAINS = ['www.youtube.com', 'youtube.com', 'youtu.be', 'www.dailymotion.com', 'dailymotion.com', 'dai.ly'];
    private ?string $host = null;

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly ParameterBagInterface $paramsBagInterface,
        private readonly TrickVideoRepository $trickVideoRepository,
        private readonly Filesystem $filesystem,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    /**
     * createVideoFromList
     *
     * @param  ?array $videosList
     *
     * @return Generator
     */
    public function createVideoFromList(?array $videosList = []): Generator
    {
        foreach ($videosList as $video) {
            yield $this->createVideo($video);
        }
    }

    /**
     * createVideoFromUrlList
     *
     * @param  ?array $videosListUrl
     *
     * @return Generator
     */
    public function createVideoFromUrlList(?array $videosListUrl = []): Generator
    {
        $videosListUrl = array_unique($videosListUrl);

        foreach ($videosListUrl as $videoUrl) {
            if ($videoUrl === null) {
                continue;
            }
            if (!is_string($videoUrl)) {
                throw new FormException("L'url fournie n'est pas valide (doit être un chaine de caractère");
            } else {
                yield $this->createVideoFromUrl($videoUrl);
            }
        }
    }

    /**
     * createVideoFromUrl
     *
     * @param  string $videoUrl
     *
     * @return TrickVideo
     */
    private function createVideoFromUrl(string $videoUrl): TrickVideo
    {
        if (!$this->isValidDomainUrl($videoUrl)) {
            throw new FormException('Un des liens n\'appartient pas à un domaine autorisé sur notre site (youtube ou dailymotion)');
        };

        $videoUrl = $this->generateEmbedUrl($videoUrl);

        $video = $this->trickVideoRepository->findOneByUrl($videoUrl);
        if ($video !== null) {
            return $video;
        }

        $video = new TrickVideo();

        $video->setCreatedAt(new DateTimeImmutable());
        $video->setExternalUrl(true);
        $video->setUrl($videoUrl);

        return $video;
    }

    /**
     * createVideo
     *
     * @param  UploadedFile $video
     *
     * @return TrickVideo
     */
    private function createVideo(UploadedFile $video): TrickVideo
    {
        $extension = $video->guessExtension();
        if (!in_array($extension, self::ALLOWED_EXTENSIONS)) {
            throw new FormException('Le fichier doit être une vidéo.');
        }

        $mimeType = $video->getMimeType();
        if (!in_array($mimeType, self::ALLOWED_MIME_EXTENSIONS)) {
            throw new FormException('Le fichier doit être une vidéo.');
        }


        $filename = uniqid('video_', true) . '.' . $extension;

        try {
            $trickVideo = new TrickVideo();
            $trickVideo->setUrl($filename);
            $trickVideo->setCreatedAt(new DateTimeImmutable());
        } catch (\Throwable $th) {
            //throw $th;
        }

        $videoDirectory = $this->paramsBagInterface->get('videos_directory');
        $video->move(
            $videoDirectory,
            $filename
        );

        return $trickVideo;
    }

    /**
     * isValidDomainUrl
     *
     * @param  string $url
     *
     * @return bool
     */
    private function isValidDomainUrl(string $url): bool
    {
        $host = parse_url($url, PHP_URL_HOST);

        if (in_array($host, self::ALLOWED_DOMAINS)) {
            if (str_contains($host, 'youtu')) {
                $this->host = 'www.youtube.com/embed/';
            } elseif (str_contains($host, 'dai')) {
                $this->host = 'geo.dailymotion.com/player.html';
            } else {
                return false;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * generateEmbedUrl
     *
     * @param  string $url
     *
     * @return string
     */
    private function generateEmbedUrl(string $url): string
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        $videoId = $match[1];

        $embedUrl = 'https://'.$this->host.$videoId;

        return $embedUrl;
    }

    /**
     * removeVideosFromDirectory
     *
     * @param  ArrayCollection $videoArray
     *
     * @return void
     */
    public function removeVideosFromDirectory(?ArrayCollection $videoArray): void
    {
        if (null === $videoArray) {
            return;
        }

        $videoDirectoryPath = $this->paramsBagInterface->get('videos_directory');

        $videosFilePath = [];
        foreach ($videoArray as $video) {
            if (count($video->getTricks()) > 1) {
                continue;
            }

            $videosFilePath[] = $videoDirectoryPath.'\\'.$video->getUrl();
            $this->entityManager->remove($video);
        }

        $this->filesystem->remove($videosFilePath);
    }
}
