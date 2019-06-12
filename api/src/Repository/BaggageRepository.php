<?php

namespace App\Repository;

use App\Entity\Baggage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Baggage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Baggage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Baggage[]    findAll()
 * @method Baggage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BaggageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Baggage::class);
    }

    // /**
    //  * @return Baggage[] Returns an array of Baggage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Baggage
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
