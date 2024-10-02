<?php

namespace App\Controller\Chatroom;

use App\Repository\ChatRoomRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ChatRoomController extends AbstractController
{
    public const CHAT_PER_PAGE = 5;

    public function __construct(
        private readonly ChatRoomRepository $chatRoomRepository,
    ) {

    }

    #[Route(
        '/chatroom/{page<\d+>?1}',
        name: 'chatroom',
        methods:Request::METHOD_GET
    )]
    public function listChatRoom(int $page): Response
    {
        $offset = ($page - 1) * self::CHAT_PER_PAGE;

        $allComments = $this->chatRoomRepository->findAll();
        $comments = array_slice($allComments, $offset, self::CHAT_PER_PAGE);

        $totalNumberPages = ceil(count($allComments) / self::CHAT_PER_PAGE);

        return $this->render('chatroom.html.twig', ['totalNumberPages' => $totalNumberPages, 'comments' => $comments]);
    }

}
