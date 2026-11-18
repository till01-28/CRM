<?php

declare(strict_types=1);

namespace App\Component\Client;

use App\Entity\Client;
use Doctrine\ORM\EntityManagerInterface;

readonly class ClientManager
{
    public function __construct(private EntityManagerInterface $entityManager)
    {

    }
    public function save(Client $client, bool $isFlushNeed): void
    {
        $this->entityManager->persist($client);

        if ($isFlushNeed)
        {
            $this->entityManager->flush();
        }
    }

}
