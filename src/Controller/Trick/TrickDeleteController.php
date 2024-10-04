<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\Repository\TrickRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TrickDeleteController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {

    }

    #[Route(
        '/delete/trick/{id<\d+>}',
        name: 'trick_delete',
        methods:Request::METHOD_POST
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function removeTrick(Trick $trick): Response
    {
        $this->entityManager->remove($trick);
        $this->entityManager->flush();

        return $this->redirectToRoute('homepage');
    }
}
