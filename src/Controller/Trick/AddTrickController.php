<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\FormModel\FormType\TrickFormType;
use App\Service\Form\TrickFormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AddTrickController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TrickFormProcessor $trickFormProcessor
    ) {

    }

    #[Route(
        '/trick/add',
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

            $this->entityManager->beginTransaction();
            try {
                $trick = ($this->trickFormProcessor)($form);

                $this->entityManager->persist($trick);
                $this->entityManager->flush();
                $this->entityManager->commit();
            } catch (\Throwable $th) {
                $this->entityManager->rollback();

                $this->addFlash(
                    'error_form',
                    $th->getMessage()
                );

                return $this->render('addTrick.html.twig', [
                    'form' => $form,
                ]);
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
