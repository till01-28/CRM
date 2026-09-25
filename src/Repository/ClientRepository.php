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

        /**
         * @return Client[] Returns an array of Client objects
         */
        public function findClientsByCompanyName(string $companyName): array
        {
            return $this->createQueryBuilder('c')
                ->select(
                    'c.id',
                    'c.name',
                    'cc.name as clientsCompanyName',
                    'ci.id as clientsImgId',
                    'c.email',
                    'c.password',
                    'c.lastActivityAt'
                )
                ->leftJoin('c.company', 'cc')
                ->leftJoin('c.image', 'ci')
                ->andWhere('cc.name LIKE :companyName')
                ->setParameter('companyName', '%' .$companyName. '%')
                ->orderBy('c.id', 'DESC')
                ->setMaxResults(10)
                ->getQuery()
                ->getResult()
            ;
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
