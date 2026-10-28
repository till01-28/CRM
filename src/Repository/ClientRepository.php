<?php

namespace App\Repository;

use App\Entity\Client;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function countCreatedToday(): int
    {
        $startOfDay = new \DateTimeImmutable('today midnight');

        return(int) $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->andWhere('c.createdAt >= :start')
            ->setParameter('start', $startOfDay)
            ->getQuery()
            ->getSingleScalarResult();
    }

        public function findOneClientByName($clientName): ?Client
      {
            return $this->createQueryBuilder('c')
                ->andWhere('c.name LIKE :clientName')
                ->setParameter('clientName', '%' . $clientName . '%')
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult()
            ;
        }
}
