<?php

declare(strict_types=1);

namespace App\Controller;

use App\Component\Client\ClientFactory;
use App\Component\Client\ClientManager;
use App\Entity\Client;

class ClientCreateAction
{
    public function __construct(private readonly ClientFactory $clientFactory,
                                private readonly ClientManager $clientManager)
    {
    }

    public function __invoke(Client $client):Client
    {
        $client = $this->clientFactory->create(
            $client->getName(),
            $client->getEmail(),
            $client->getPassword()
        );

        $this->clientManager->save($client, true);

        return $client;
    }
}
