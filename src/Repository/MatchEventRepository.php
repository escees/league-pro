<?php

namespace App\Repository;

use App\Entity\MatchEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MatchEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchEvent[]    findAll()
 * @method MatchEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MatchEvent::class);
    }

    // /**
    //  * @return MatchEvent[] Returns an array of MatchEvent objects
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
    public function findOneBySomeField($value): ?MatchEvent
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
