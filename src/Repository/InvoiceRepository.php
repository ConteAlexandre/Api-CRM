<?php

namespace App\Repository;

use App\Entity\Invoice;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Invoice|null find($id, $lockMode = null, $lockVersion = null)
 * @method Invoice|null findOneBy(array $criteria, array $orderBy = null)
 * @method Invoice[]    findAll()
 * @method Invoice[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InvoiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Invoice::class);
    }

    /**
     * @param $slug
     *
     * @return int|mixed[]|string
     */
    public function findAllInvoiceByClient($slug)
    {
        $qb = $this->createQueryBuilder('i');

        $qb
            ->leftJoin('i.client', 'client')
            ->select('i', 'client')
            ->where('client.slug = :slug')
            ->andWhere('i.enabled = :enabled')
            ->setParameters(['slug' => $slug, 'enabled' => true])
        ;

        return $qb->getQuery()->getArrayResult();
    }
}
