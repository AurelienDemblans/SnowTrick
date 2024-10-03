<?php

declare (strict_types=1);

namespace App\Service;

use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFactory
{
    public function __construct(private readonly UserPasswordHasherInterface $passwordHasher)
    {

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
        // hash the password (based on the security.yaml config for the $user class)
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $user->getPassword()
        );
        $user->setPassword($hashedPassword);
        $user->setRole('ROLE_USER');

        return $user;
    }
}
