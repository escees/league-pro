<?php

namespace App\Repository;

use App\Entity\MatchDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MatchDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchDetails[]    findAll()
 * @method MatchDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MatchDetails::class);
    }

    // /**
    //  * @return MatchDetails[] Returns an array of MatchDetails objects
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
    public function findOneBySomeField($value): ?MatchDetails
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
