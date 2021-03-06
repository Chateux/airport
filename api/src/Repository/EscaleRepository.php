<?php

namespace App\Repository;

use App\Entity\Escale;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Escale|null find($id, $lockMode = null, $lockVersion = null)
 * @method Escale|null findOneBy(array $criteria, array $orderBy = null)
 * @method Escale[]    findAll()
 * @method Escale[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EscaleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Escale::class);
    }

    // /**
    //  * @return Escale[] Returns an array of Escale objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Escale
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
