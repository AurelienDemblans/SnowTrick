<?php

namespace App\Controller;

use App\Repository\TrickPictureRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class Homepage extends AbstractController
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly TrickPictureRepository $trickPictureRepository,
        private readonly SerializerInterface $serializer,
    ) {

    }


    #[Route(
        '/accueil',
        name: 'homepage',
        methods:Request::METHOD_GET
    )]
    public function showList(SessionInterface $session, Request $request)
    {
        $session = $request->getSession();

        $errorMessage = $session->get('error_message') ?? null;
        $session->remove('error_message');

        $trickList = $this->trickRepository->findAll();
        $homepagePicture = $this->trickPictureRepository->findOneBy(['isHomepage' => true]);

        return $this->render('homepage.html.twig', ['trickList' => $trickList, "homepagePicture" => $homepagePicture, 'error_message' => $errorMessage]);
    }
}
