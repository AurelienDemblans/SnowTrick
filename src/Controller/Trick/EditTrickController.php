<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\Exception\FormException;
use App\Form\TrickFormType;
use App\Repository\TrickPictureRepository;
use App\Repository\TrickVideoRepository;
use App\Service\DeletePictureFactory;
use App\Service\DeleteVideoFactory;
use App\Service\TrickFormProcessor;
use Doctrine\Common\Collections\ArrayCollection;
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
        private readonly DeletePictureFactory $deletePictureFactory,
        private readonly DeleteVideoFactory $deleteVideoFactory,
        private readonly EntityManagerInterface $entityManager,
        private readonly TrickFormProcessor $trickFormProcessor
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
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $videosToDelete = explode(',', $request->request->get('videos_id'));
            $picturesToDelete = explode(',', $request->request->get('pictures_id'));

            $pictureCollection = new ArrayCollection();
            foreach ($picturesToDelete as $pictureId) {
                $picture = $this->trickPictureRepository->find($pictureId);

                if ($picture !== null) {
                    $pictureCollection->add($picture);
                    $trick->removeTrickPicture($picture);
                }
            }

            $videoCollection = new ArrayCollection();
            foreach ($videosToDelete as $videoId) {
                $video = $this->trickVideoRepository->find($videoId);

                if ($video !== null) {
                    $trick->removeTrickVideo($video);

                    if (count($video->getTricks()) > 1) {
                        continue;
                    }

                    $videoCollection->add($video);
                }
            }

            $this->entityManager->beginTransaction();
            try {
                if ($trick->getTrickPictures()->count() === 0) {
                    throw new FormException('Il faut obligatoirement une image pour le Trick.');
                }
                $trick = ($this->trickFormProcessor)($form);

                $this->entityManager->persist($trick);
                $this->entityManager->flush();
                $this->entityManager->commit();

                $this->deletePictureFactory->deletePicture($pictureCollection);
                $this->deleteVideoFactory->deleteVideo($videoCollection);
            } catch (\Throwable $th) {
                $this->entityManager->rollback();

                $this->addFlash(
                    'error_form',
                    $th->getMessage()
                );

                return $this->render('editTrick.html.twig', [
                    'form' => $form,
                    'trick' => $trick
                ]);
            }

            $this->addFlash(
                'success_trick_edited',
                'Le trick à correctement été mis à jour.'
            );

            return $this->redirectToRoute('trick', array('id' => $trick->getId(), 'slug' => $trick->getSlug()));

        }

        return $this->render('editTrick.html.twig', [
            'form' => $form,
            'trick' => $trick
        ]);
    }
}
