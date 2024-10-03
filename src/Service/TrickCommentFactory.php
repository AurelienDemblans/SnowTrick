<?php

declare (strict_types=1);

namespace App\Service;

use App\Entity\TrickComment;
use App\Repository\TrickRepository;
use Symfony\Bundle\SecurityBundle\Security;

class TrickCommentFactory
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly Security $security,
    ) {

    }
    public function addNewComment(string $commentContent, int $trickId): TrickComment
    {
        $comment = new TrickComment();

        $comment->setContent($commentContent);
        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setTrick($this->trickRepository->find($trickId));
        $comment->setUser($this->security->getUser());


        return $comment;
    }
}
