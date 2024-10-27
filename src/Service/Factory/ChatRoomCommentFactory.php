<?php

declare (strict_types=1);

namespace App\Service\Factory;

use App\Entity\ChatRoomComment;
use App\Entity\TrickComment;
use App\Repository\TrickRepository;
use Symfony\Bundle\SecurityBundle\Security;

class ChatRoomCommentFactory
{
    public function __construct(
        private readonly TrickRepository $trickRepository,
        private readonly Security $security,
    ) {

    }
    public function addNewComment(string $commentContent): ChatRoomComment
    {
        $comment = new ChatRoomComment();

        $comment->setContent($commentContent);
        $comment->setCreatedAt(new \DateTimeImmutable());
        $comment->setUser($this->security->getUser());

        return $comment;
    }
}
