<?php

namespace App\Repository;

use App\Entity\LUC;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method LUC|null find($id, $lockMode = null, $lockVersion = null)
 * @method LUC|null findOneBy(array $criteria, array $orderBy = null)
 * @method LUC[]    findAll()
 * @method LUC[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LUCRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LUC::class);
    }

    /**
     * Recherche les chapitre en fonction du formulaire
     * @return void
     */ 
    public function search($mots){
        $query = $this->createQueryBuilder('a');
        if($mots != null){
            $query->Where('MATCH_AGAINST(a.chapter) AGAINST(:mot boolean)>0')
                ->setParameter('mots', $mots);
        }

        return $query->getQuery()->getResult();
    }


    // /**
    //  * @return LUC[] Returns an array of LUC objects
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
    public function findOneBySomeField($value): ?LUC
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
