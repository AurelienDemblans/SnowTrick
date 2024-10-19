<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\Exception\SnowTrickException;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TrickDeleteController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TrickRepository $trickRepository,
        private readonly ParameterBagInterface $paramsBagInterface,
        private readonly Filesystem $filesystem
    ) {
    }

    #[Route(
        '/delete/trick/{id<\d+>}',
        name: 'trick_delete',
        methods:Request::METHOD_POST
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function removeTrick(?Trick $trick): Response
    {
        if (!$trick) {
            throw new SnowTrickException('Cette figure a déjà été supprimée');
        }

        $pictureDirectoryPath = $this->paramsBagInterface->get('pictures_directory');
        $videoDirectoryPath = $this->paramsBagInterface->get('videos_directory');

        $picturesFilePath = [];
        foreach ($trick->getTrickPictures() as $picture) {
            $picturesFilePath[] = $pictureDirectoryPath.'\\'.$picture->getUrl();
        }

        $videosFilePath = [];
        foreach ($trick->getTrickVideos() as $video) {
            if (count($video->getTricks()) > 1) {
                continue;
            }

            $videosFilePath[] = $videoDirectoryPath.'\\'.$video->getUrl();
            $this->entityManager->remove($video);
        }

        $this->filesystem->remove($picturesFilePath);
        $this->filesystem->remove($videosFilePath);

        $this->entityManager->remove($trick);
        $this->entityManager->flush();

        $this->addFlash(
            'success_trick_deleted',
            'Trick supprimé avec succès !'
        );
        return $this->redirectToRoute('homepage');
    }
}
