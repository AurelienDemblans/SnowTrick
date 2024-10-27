<?php

namespace App\Controller\Trick;

use App\Entity\Trick;
use App\Exception\SnowTrickException;
use App\Repository\TrickCommentRepository;
use App\Repository\TrickPictureRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TrickShowController extends AbstractController
{
    public const COMMENT_OFFSET = 0;
    public const COMMENT_LIMIT = 5;

    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly TrickPictureRepository $trickPictureRepository,
        private readonly TrickCommentRepository $commentRepository
    ) {

    }

    #[Route(
        '/trick/{slug}',
        name: 'trick',
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

        return $this->render('trick.html.twig', ['trick' => $trick, 'comments' => $comments]);
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

        return $this->render('listComment.html.twig', ['comments' => $comments, 'hasMoreComments' => $hasMoreComments]);
    }


}
