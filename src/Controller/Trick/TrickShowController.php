<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\Repository\TrickPictureRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class TrickShowController extends AbstractController
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly TrickPictureRepository $trickPictureRepository,
        private readonly SerializerInterface $serializer
    ) {

    }

    #[Route(
        '/trick/{id}/{slug}',
        name: 'trick',
        methods:Request::METHOD_GET
    )]
    public function showTrick(Trick $trick): Response
    {
        return $this->render('trick.html.twig', ['trick' => $trick]);
    }
}
