<?php

namespace App\Controller\User;

use App\Entity\User;
use App\FormModel\FormType\AddUserFormType;
use App\Service\UserFactory;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddUserController extends AbstractController
{
    public function __construct(
        private readonly UserFactory $userFactory,
        private readonly EntityManagerInterface $entityManager
    ) {

    }

    #[Route(
        '/sign-up',
        name: 'sign-up',
        methods:[Request::METHOD_POST, Request::METHOD_GET]
    )]
    public function addUser(Request $request): Response
    {
        $newUser = new User();

        $required_field = true;
        $form = $this->createForm(AddUserFormType::class, $newUser, ['required_field' => $required_field]);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $filledUser = $form->getData();

            $user = $this->userFactory->createUser($filledUser);

            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash(
                'user_created',
                'Félicitation, vous avez bien été enregistré !'
            );

            return $this->redirectToRoute('homepage', array('user' => $user));
        }

        return $this->render('signup.html.twig', [
            'form' => $form,
        ]);
    }
}
