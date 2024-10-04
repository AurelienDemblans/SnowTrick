<?php

namespace App\Controller\Chatroom;

use App\Service\ChatRoomCommentFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AddChatRoomCommentController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {

    }

    #[Route(
        '/add-comment/chatroom',
        name: 'add_chatroom_comment',
        methods:Request::METHOD_POST
    )]
    #[IsGranted('ROLE_USER')]
    public function listChatRoomComment(Request $request, ChatRoomCommentFactory $chatRoomCommentFactory): Response
    {
        $comment = $request->request->get('commentContent');
        $page = $request->request->get('page');

        if (!is_string($comment) || empty(trim($comment))) {

            $this->addFlash(
                'error_comment',
                'Commentaire vide ou invalide, il n\'a pas été enregistré.'
            );

            return $this->redirectToRoute('chatroom', ['page' => $page]);
        }

        $newComment = $chatRoomCommentFactory->addNewComment($comment);

        $this->entityManager->persist($newComment);
        $this->entityManager->flush();

        $this->addFlash(
            'succes_comment',
            'Commentaire ajouté avec succès'
        );

        return $this->redirectToRoute('chatroom', ['page' => $page]);
    }

}
