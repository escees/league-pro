<?php

namespace App\Repository;

use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Team|null find($id, $lockMode = null, $lockVersion = null)
 * @method Team|null findOneBy(array $criteria, array $orderBy = null)
 * @method Team[]    findAll()
 * @method Team[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TeamRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Team::class);
    }

     /**
      * @return Team[] Returns an array of Team objects
      */
//    /*
    public function getTeamStandings()
    {
        return $this->createQueryBuilder('t')
            ->select('t.points')
            ->addSelect('t.name')
            ->addSelect('t.wins')
            ->addSelect('t.loses')
            ->addSelect('t.winsAfterPenalties')
            ->addSelect('t.losesAfterPenalties')
            ->addSelect('t.goalsScored')
            ->addSelect('t.goalsConceded')
            ->addSelect('t.goalsScored  - t.goalsConceded as goals_diff')
            ->addSelect('t.wins + t.loses + t.winsAfterPenalties + t.losesAfterPenalties as played')
            ->orderBy('t.points', 'DESC')
            ->addOrderBy('goals_diff', 'DESC')
            ->getQuery()
            ->execute()
        ;
    }
//    */

    /*
    public function findOneBySomeField($value): ?Team
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
