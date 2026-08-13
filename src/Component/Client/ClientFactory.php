<?php

declare(strict_types=1);

namespace App\Component\Client;

use App\Entity\Client;
use App\Entity\Company;
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
    public function create(string $name, string $email, string $password, Company $company): Client
    {
        $client = new Client();

        $hashedPassword = $this->passwordHasher->hashPassword($client, $password);

        $client -> setName($name);
        $client -> setEmail($email);
        $client -> setPassword($hashedPassword);
        $client -> setCompany($company);
        $client -> setLastActivityAt(new DatePoint(timezone: new DateTimeZone("Asia/Tashkent")));

        return $client;
    }
}
