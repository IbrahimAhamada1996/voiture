<?php

namespace App\Repository;

use App\Entity\Voiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Voiture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Voiture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Voiture[]    findAll()
 * @method Voiture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

     /**
      * @return Voiture[] Returns an array of Voiture objects
      */
    
    public function findByTypeoffre($offreType)
    {
        return $this->createQueryBuilder('v')
            ->select('to','v')
            ->join('v.typeOffre','to')
            ->where('v.typeVoiture = :typeVoiture')
            ->andWhere('to.ajoutInPanier = :ajoutInPanier')
            ->setParameter('typeVoiture', $offreType)
            ->setParameter('ajoutInPanier', true)
            ->orderBy('v.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findOffrePublie($vendre,$location)
    {
        return $this->createQueryBuilder('v')
            ->select('to','v')
            ->join('v.typeOffre','to')
            ->where('v.typeVoiture = :vendre')
            ->orWhere('v.typeVoiture = :location')
            ->andWhere('to.isValid = :isValid')
            ->setParameter('vendre', $vendre)
            ->setParameter('location', $location)
            ->setParameter('isValid', false)
            ->orderBy('v.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    
    

    // /**
    //  * @return Voiture[] Returns an array of Voiture objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Voiture
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
