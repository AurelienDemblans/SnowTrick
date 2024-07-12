<?php

namespace App\Controller;

use App\Repository\TrickPictureRepository;
use App\Repository\TrickRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class Trick extends AbstractController
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly TrickPictureRepository $trickPictureRepository,
        private readonly SerializerInterface $serializer
    ) {

    }

    #[Route(
        '/accueil',
        name: 'homepage',
        methods:Request::METHOD_GET
    )]
    public function showList()
    {
        $trickList = $this->trickRepository->findAll();
        $homepagePicture = $this->trickPictureRepository->findOneBy(['isHomepage' => true]);

        return $this->render('homepage.html.twig', ['trickList' => $trickList, "homepagePicture" => $homepagePicture]);
    }
}
