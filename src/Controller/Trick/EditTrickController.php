<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\FormModel\FormType\TrickFormType;
use App\Repository\TrickPictureRepository;
use App\Repository\TrickRepository;
use App\Repository\TrickVideoRepository;
use App\Service\Form\TrickFormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class EditTrickController extends AbstractController
{
    public function __construct(
        private readonly TrickPictureRepository $trickPictureRepository,
        private readonly TrickVideoRepository $trickVideoRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly TrickFormProcessor $trickFormProcessor,
        private readonly TrickRepository $trickRepository,
    ) {

    }
    #[Route(
        '/edit/trick/{id<\d+>}',
        name: 'app_edit_trick',
        methods:[Request::METHOD_POST, Request::METHOD_GET]
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function index(?Trick $trick, Request $request): Response
    {
        $form = $this->createForm(TrickFormType::class, $trick, [
            'picture_required' => false,
            'from' => 'EDIT'
        ]);
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
                $this->entityManager->clear();

                $this->addFlash(
                    'error_form',
                    $th->getMessage()
                );

                $trick = $this->trickRepository->find($trick->getId());

                return $this->render('editTrick.html.twig', [
                    'form' => $form,
                    'trick' => $trick
                ]);
            }

            $this->addFlash(
                'success_trick_edited',
                'Le trick a correctement été mis à jour.'
            );

            return $this->redirectToRoute('trick', array('id' => $trick->getId(), 'slug' => $trick->getSlug()));

        }

        return $this->render('editTrick.html.twig', [
            'form' => $form,
            'trick' => $trick
        ]);
    }
}
