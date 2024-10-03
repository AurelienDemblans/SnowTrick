<?php

declare (strict_types=1);

namespace App\Controller\TrickComment;

use App\Service\TrickCommentFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AddTrickComment extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {

    }
    #[Route(
        '/add-comment/trick-comment',
        name: 'add_trick_comment',
        methods:Request::METHOD_POST
    )]
    #[IsGranted('ROLE_USER')]
    public function addComment(Request $request, TrickCommentFactory $trickCommentFactory): Response
    {
        $comment = $request->request->get('commentContent');
        $trickId = $request->request->get('trick_id');
        $trickSlug = $request->request->get('trick_slug');

        if (!is_string($comment) || empty(trim($comment))) {

            $this->addFlash(
                'error_comment',
                'Commentaire vide ou invalide, il n\'a pas été enregistré.'
            );

            return $this->redirectToRoute('trick', ['id' => $trickId, 'slug' => $trickSlug]);
        }

        $newComment = $trickCommentFactory->addNewComment($comment, (int)$trickId);

        $this->entityManager->persist($newComment);
        $this->entityManager->flush();

        $this->addFlash(
            'succes_comment',
            'Commentaire ajouté avec succès'
        );

        return $this->redirectToRoute('trick', ['id' => $trickId, 'slug' => $trickSlug]);
    }
}
