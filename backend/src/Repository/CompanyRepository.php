<?php

namespace App\Repository;

use App\Entity\Company;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Company>
 */
class CompanyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Company::class);
    }

    public function countCreatedToday(): int
    {
        $startOfDay = new \DateTimeImmutable('today midnight');

        return (int) $this->createQueryBuilder('c')
            ->select('count(c.id)')
            ->andWhere('c.createdAt >= :start')
            ->setParameter('start', $startOfDay)
            ->getQuery()
            ->getSingleScalarResult();
    }

    //    public function findOneBySomeField($value): ?Company
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
