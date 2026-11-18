<?php

declare(strict_types=1);

namespace App\Component\Company;

use App\Entity\Company;
use Doctrine\ORM\EntityManagerInterface;

readonly class CompanyManager
{
    public function __construct(private EntityManagerInterface $entityManager)
    {

    }

    public function save(Company $company, bool $isFlushNeed): void
    {
        $this->entityManager->persist($company);

        if ($isFlushNeed)
        {
            $this->entityManager->flush();
        }
    }
}
