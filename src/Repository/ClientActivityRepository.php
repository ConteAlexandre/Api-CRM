<?php

namespace App\Repository;

use App\Entity\ClientActivity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ClientActivity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClientActivity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClientActivity[]    findAll()
 * @method ClientActivity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientActivityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClientActivity::class);
    }

    // /**
    //  * @return ClientActivity[] Returns an array of ClientActivity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClientActivity
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
