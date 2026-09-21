<?php

declare(strict_types=1);

namespace App\Component\Company;

use App\Entity\Company;
use App\Entity\MediaObject;
use DateTimeZone;
use Symfony\Component\Clock\DatePoint;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class CompanyFactory
{
    /**
     * @throws \DateMalformedStringException
     */
    public function create( string $name, string $email, string $password, MediaObject $image): Company
    {
        $company = new Company();

        $company -> setName($name);
        $company -> setEmail($email);
        $company -> setPassword($password);
        $company -> setImage($image);
        $company -> setLastActivityAt(new DatePoint(timezone: new DateTimeZone("Asia/Tashkent")));

        return $company;
    }
}
