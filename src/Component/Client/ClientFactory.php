<?php

declare(strict_types=1);

namespace App\Component\Client;

use App\Entity\Client;
use App\Entity\Company;
use App\Entity\MediaObject;
use DateTimeZone;
use Symfony\Component\Clock\DatePoint;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class ClientFactory
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {

    }

    /**
     * @throws \DateMalformedStringException
     */
    public function create(
        string $name,
        string $email,
        string $password,
        Company $company,
        MediaObject $image
    ): Client
    {
        $client = new Client();

        $hashedPassword = $this->passwordHasher->hashPassword($client, $password);

        $client -> setName($name);
        $client -> setEmail($email);
        $client -> setPassword($hashedPassword);
        $client -> setCompany($company);
        $client -> setImage($image);
        $client -> setLastActivityAt(new DatePoint(timezone: new DateTimeZone("Asia/Tashkent")));

        return $client;
    }
}
