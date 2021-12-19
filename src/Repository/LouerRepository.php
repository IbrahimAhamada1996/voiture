<?php

namespace App\Repository;

use App\Entity\Louer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Louer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Louer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Louer[]    findAll()
 * @method Louer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LouerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Louer::class);
    }

    // /**
    //  * @return Louer[] Returns an array of Louer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Louer
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
