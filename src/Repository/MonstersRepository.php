<?php

namespace App\Repository;

use App\Entity\Monsters;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Monsters|null find($id, $lockMode = null, $lockVersion = null)
 * @method Monsters|null findOneBy(array $criteria, array $orderBy = null)
 * @method Monsters[]    findAll()
 * @method Monsters[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MonstersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Monsters::class);
    }

    // /**
    //  * @return Monsters[] Returns an array of Monsters objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Monsters
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
