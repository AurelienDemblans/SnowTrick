<?php

declare (strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class DeletePictureFactory
{
    public function __construct(
        private readonly ParameterBagInterface $paramsBagInterface,
        private readonly Filesystem $filesystem
    ) {
    }

    public function deletePicture(Iterable $pictureArray)
    {
        $pictureDirectoryPath = $this->paramsBagInterface->get('pictures_directory');

        $picturesFilePath = [];
        foreach ($pictureArray as $picture) {
            $picturesFilePath[] = $pictureDirectoryPath.'\\'.$picture->getUrl();
        }

        $this->filesystem->remove($picturesFilePath);
    }
}
