<?php

declare (strict_types=1);

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class DeleteVideoFactory
{
    public function __construct(
        private readonly ParameterBagInterface $paramsBagInterface,
        private readonly Filesystem $filesystem,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function deleteVideo(Iterable $videoArray)
    {
        $videoDirectoryPath = $this->paramsBagInterface->get('videos_directory');

        $videosFilePath = [];
        foreach ($videoArray as $video) {
            $videosFilePath[] = $videoDirectoryPath.'\\'.$video->getUrl();
            $this->entityManager->remove($video);
        }

        $this->filesystem->remove($videosFilePath);
    }
}
