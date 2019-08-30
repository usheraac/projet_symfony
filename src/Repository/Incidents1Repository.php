<?php

namespace App\Repository;

use App\Entity\Incidents1;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Incidents1|null find($id, $lockMode = null, $lockVersion = null)
 * @method Incidents1|null findOneBy(array $criteria, array $orderBy = null)
 * @method Incidents1[]    findAll()
 * @method Incidents1[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Incidents1Repository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Incidents1::class);
    }

//    /**
//     * @return Incidents1[] Returns an array of Incidents1 objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Incidents1
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
