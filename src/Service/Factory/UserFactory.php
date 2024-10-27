<?php

declare (strict_types=1);

namespace App\Service\Factory;

use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository $userRepository
    ) {

    }
    /**
     * createUser
     *
     * @param  User $user
     *
     * @return User
     */
    public function createUser(User $user): User
    {
        //check email already used
        if ($this->userRepository->findOneByEmail($user->getEmail()) !== null) {
            throw new Exception('cet email est déjà utilisé');
        }

        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $user->getPassword()
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_ADMIN']);

        return $user;
    }
}
