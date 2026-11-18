<?php

declare(strict_types=1);

namespace App\Component\User;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

readonly class UserManager
{
    public function __construct(private EntityManagerInterface $entityManager) {

    }
    public function save(User $user, bool $isFlushNeeded = false): void
    {
        $this->entityManager->persist($user);

        if ($isFlushNeeded)
        {
            $this->entityManager->flush();
        }

    }

}
