<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\Form\TrickFormType;
use App\Service\PictureFactory;
use App\Service\TrickAddFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AddTrickController extends AbstractController
{
    public function __construct(
        private readonly TrickAddFactory $trickAddFactory,
        private readonly PictureFactory $pictureFactory,
        private readonly EntityManagerInterface $entityManager
    ) {

    }

    #[Route(
        '/add/trick',
        name: 'trick_add',
        methods:[Request::METHOD_POST, Request::METHOD_GET]
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function addTrick(Request $request): Response
    {
        $newTrick = new Trick();

        $form = $this->createForm(TrickFormType::class, $newTrick);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $filledTrick = $form->getData();
            $picturesList = $form->get('trickPictures')->getData();
            // $videosList = $form->get('trickVideos')->getData();

            $this->entityManager->beginTransaction();
            try {
                $trickPictures = $this->pictureFactory->createPictureFromList($picturesList);
                $trick = $this->trickAddFactory->createTrick($filledTrick, $trickPictures);

                $this->entityManager->persist($trick);

                $this->entityManager->flush();
                $this->entityManager->commit();
            } catch (\Throwable $th) {
                dd($th);
                $this->entityManager->rollback();
            }

            $this->addFlash(
                'trick_created',
                'Félicitation, vous avez créé un nouveau Trick !'
            );

            return $this->redirectToRoute('homepage', array('trick' => $trick));
        }

        return $this->render('addTrick.html.twig', [
            'form' => $form,
        ]);
    }
}
