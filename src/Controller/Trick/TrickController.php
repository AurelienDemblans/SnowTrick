<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\Exception\SnowTrickException;
use App\FormModel\FormType\TrickFormType;
use App\Repository\TrickCommentRepository;
use App\Repository\TrickPictureRepository;
use App\Repository\TrickRepository;
use App\Repository\TrickVideoRepository;
use App\Service\Form\TrickFormProcessor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class TrickController extends AbstractController
{
    public const COMMENT_OFFSET = 0;
    public const COMMENT_LIMIT = 5;

    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly TrickCommentRepository $commentRepository,
        private readonly TrickPictureRepository $trickPictureRepository,
        private readonly TrickVideoRepository $trickVideoRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly TrickFormProcessor $trickFormProcessor,
        private readonly ParameterBagInterface $paramsBagInterface,
        private readonly Filesystem $filesystem
    ) {
    }

    #[Route(
        '/trick-{slug}',
        name: 'trick_show',
        methods:Request::METHOD_GET,
    )]
    public function showTrick(string $slug): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);

        try {
            $comments = $this->commentRepository->findCommentsByTrickPaginated($trick, self::COMMENT_OFFSET, self::COMMENT_LIMIT);
        } catch (\Throwable $th) {
            throw new SnowTrickException('Impossible d\'afficher ce trick', code:404, previous:$th);
        }

        return $this->render('Trick/trick.html.twig', ['trick' => $trick, 'comments' => $comments]);
    }

    #[Route(
        '/trick_comments/{id<\d+>}/comments_offset/{offset<\d+>}',
        name: 'trick_comments',
        methods:Request::METHOD_GET
    )]
    public function loadMoreComments(Trick $trick, int $offset = self::COMMENT_LIMIT): Response
    {
        $comments = $this->commentRepository->findCommentsByTrickPaginated($trick, $offset, self::COMMENT_LIMIT);

        $moreComments = $this->commentRepository->findCommentsByTrickPaginated($trick, $offset + self::COMMENT_LIMIT, 1);
        $hasMoreComments = count($moreComments) > 0 ? true : false;

        return $this->render('Utils/listComment.html.twig', ['comments' => $comments, 'hasMoreComments' => $hasMoreComments]);
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

                return $this->render('Trick/addTrick.html.twig', [
                    'form' => $form,
                ]);
            }

            $this->addFlash(
                'success_trick_created',
                'Félicitation, vous avez créé un nouveau Trick !'
            );

            return $this->redirectToRoute('homepage', array('trick' => $trick));
        }

        return $this->render('Trick/addTrick.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(
        '/trick/{slug}/edit',
        name: 'app_edit_trick',
        methods:[Request::METHOD_POST, Request::METHOD_GET]
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function index(?string $slug, Request $request): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);

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

                return $this->render('Trick/editTrick.html.twig', [
                    'form' => $form,
                    'trick' => $trick
                ]);
            }

            $this->addFlash(
                'success_trick_edited',
                'Le trick a correctement été mis à jour.'
            );

            return $this->redirectToRoute('trick', array('slug' => $trick->getSlug()));

        }

        return $this->render('Trick/editTrick.html.twig', [
            'form' => $form,
            'trick' => $trick
        ]);
    }

    #[Route(
        '/trick/{slug}/delete',
        name: 'trick_delete',
        methods:Request::METHOD_POST
    )]
    #[IsGranted('ROLE_ADMIN')]
    public function removeTrick(?string $slug): Response
    {
        $trick = $this->trickRepository->findOneBy(['slug' => $slug]);

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
