<?php

declare(strict_types=1);

namespace App\Component\User;

use App\Entity\MediaObject;
use App\Entity\User;
use DateTimeZone;
use Symfony\Component\Clock\DatePoint;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class UserFactory
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }
    /**
     * @throws \DateMalformedStringException
     */
    public function create(
        string $familyName,
        string $givenName,
        string $email,
        string $plainPassword,
        MediaObject $image
    ): User {

        $user = new User();

        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);

        $user->setFamilyName($familyName);
        $user->setGivenName($givenName);
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setPlainPassword($plainPassword);
        $user->setImage($image);
        $user->setCreatedAt(new DatePoint(timezone: new DateTimeZone("Asia/Tashkent")));

        return $user;
    }
}
