<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\Exception\FormException;
use App\Form\TrickFormType;
use App\Service\PictureFactory;
use App\Service\TrickAddFactory;
use App\Service\VideoFactory;
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
        private readonly VideoFactory $videoFactory,
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
            $videosList = $form->get('trickVideos')->getData();
            $videosListUrl = $form->get('trickVideosUrl')->getData();

            $this->entityManager->beginTransaction();
            try {
                $trickPictures = $this->pictureFactory->createPictureFromList($picturesList);
                $trickVideos = $this->videoFactory->createVideoFromList($videosList, $videosListUrl);
                $trick = $this->trickAddFactory->createTrick($filledTrick, $trickPictures, $trickVideos);

                $this->entityManager->persist($trick);

                $this->entityManager->flush();
                $this->entityManager->commit();
            } catch (\Throwable $th) {
                $this->entityManager->rollback();
                if ($th instanceof FormException) {
                    throw new FormException($th->getMessage());
                }
            }

            $this->addFlash(
                'success_trick_created',
                'Félicitation, vous avez créé un nouveau Trick !'
            );

            return $this->redirectToRoute('homepage', array('trick' => $trick));
        }

        return $this->render('addTrick.html.twig', [
            'form' => $form,
        ]);
    }
}
