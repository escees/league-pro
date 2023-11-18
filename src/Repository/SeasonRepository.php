<?php

namespace App\Repository;

use App\Entity\Season;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Season|null find($id, $lockMode = null, $lockVersion = null)
 * @method Season|null findOneBy(array $criteria, array $orderBy = null)
 * @method Season[]    findAll()
 * @method Season[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeasonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Season::class);
    }

    public function getStandings(string $leagueName)
    {
        return $this->createQueryBuilder('s')
            ->leftJoin('s.matchDays', 'sm')
            ->leftJoin('sm.matches', 'smm')
            ->leftJoin('smm.homeTeam', 'smmt')
            ->leftJoin('s.league', 'sl')
            ->orderBy('smmt.points', 'DESC')
            ->addOrderBy('smmt.goalsScored', 'DESC')
            ->andWhere('sl.name = :leagueName')
            ->andWhere('s.active = true')
            ->setParameter('leagueName', $leagueName)
            ->getQuery()
            ->execute();

    }
}
