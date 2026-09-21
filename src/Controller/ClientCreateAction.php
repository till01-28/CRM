<?php

declare(strict_types=1);

namespace App\Controller;

use ApiPlatform\Validator\ValidatorInterface;
use App\Component\Client\ClientFactory;
use App\Component\Client\ClientManager;
use App\Entity\Client;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientCreateAction extends AbstractController
{
    public function __construct(
        private readonly ClientFactory $clientFactory,
        private readonly ClientManager $clientManager,
        private readonly ValidatorInterface $validator
    )
    {
    }

    /**
     * @throws \DateMalformedStringException
     */
    public function __invoke(Client $client):Client

    {
        $this->validator->validate($client);

        $client = $this->clientFactory->create(
            $client->getName(),
            $client->getEmail(),
            $client->getPassword(),
            $client->getCompany(),
            $client->getImage()
        );

        $this->clientManager->save($client, true);

        return $client;
    }
}
