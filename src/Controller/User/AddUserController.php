<?php

namespace App\Controller\User;

use App\Entity\User;
use App\FormModel\FormType\AddUserFormType;
use App\Repository\UserRepository;
use App\Service\Factory\UserFactory;
use App\Service\JWTService;
use App\Service\SendMailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AddUserController extends AbstractController
{
    public function __construct(
        private readonly UserFactory $userFactory,
        private readonly EntityManagerInterface $entityManager,
        private readonly SendMailService $mail,
        private readonly JWTService $jwt,
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

            $header = [
                'typ' => 'JWT',
                'alg' => 'HS256'
            ];

            $payload = [
                'user_id' => $user->getId()
            ];

            $token = $this->jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

            $this->mail->send(
                'no-reply@monsite.net',
                $user->getEmail(),
                'Activation de votre compte sur le site SnowTrick',
                'register',
                compact('user', 'token')
            );


            return $this->redirectToRoute('homepage', array('user' => $user));
        }

        return $this->render('Authentication/signup.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/verif/{token}', name: 'verify_user')]
    public function verifyUser(
        $token,
        JWTService $jwt,
        UserRepository $usersRepository,
        EntityManagerInterface $em
    ): Response {
        if ($jwt->isValid($token) && !$jwt->isExpired($token) && $jwt->check($token, $this->getParameter('app.jwtsecret'))) {
            $payload = $jwt->getPayload($token);

            $user = $usersRepository->find($payload['user_id']);

            if ($user && !$user->getIsVerified()) {
                $user->setIsVerified(true);
                $em->flush($user);
                $this->addFlash('success', 'Utilisateur activé');
                return $this->redirectToRoute('homepage');
            }
        }

        $this->addFlash('danger', 'Le token est invalide ou a expiré');
        return $this->redirectToRoute('app_login');
    }

    #[Route('/renvoiverif', name: 'resend_verif')]
    public function resendVerif(JWTService $jwt, SendMailService $mail, UserRepository $usersRepository): Response
    {
        /** @var UserEntity $user */
        $user = $this->getUser();

        if (!$user) {
            $this->addFlash('danger', 'Vous devez être connecté pour accéder à cette page');
            return $this->redirectToRoute('app_login');
        }

        if ($user->getIsVerified()) {
            $this->addFlash('warning', 'Cet utilisateur est déjà activé');
            return $this->redirectToRoute('homepage');
        }

        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        $payload = [
            'user_id' => $user->getId()
        ];

        $token = $jwt->generate($header, $payload, $this->getParameter('app.jwtsecret'));

        $mail->send(
            'no-reply@monsite.net',
            $user->getEmail(),
            'Activation de votre compte sur le site SnowTrick',
            'register',
            compact('user', 'token')
        );

        $this->addFlash('success', 'Email de vérification envoyé');
        return $this->redirectToRoute('homepage');
    }
}
