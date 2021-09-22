<?php

namespace App\Repository;

use App\Entity\League;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
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

    public function getAllTeamsWithoutLeague(): array
    {
        return $this->createQueryBuilder('t')
            ->where('t.season IS NULL')
            ->getQuery()
            ->execute();
    }

    public function getAllTeamsWithLeague(): QueryBuilder
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.season', 'ts')
            ->leftJoin('ts.league', 'tsl')
            ->where('t.season IS NOT NULL')
            ->andWhere('ts.league IS NOT NULL');
    }

    public function getAllTeamsForLeagueEntity(League $league): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.season', 'ts')
            ->leftJoin('ts.league', 'tsl')
            ->where('t.season IS NOT NULL')
            ->andWhere('tsl = :league')
            ->setParameter('league', $league)
            ->getQuery()
            ->getResult();
    }

    public function getAllTeamsForLeague(string $league): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.season', 'ts')
            ->leftJoin('ts.league', 'tsl')
            ->where('t.season IS NOT NULL')
            ->andWhere('tsl.name = :leagueName')
            ->setParameter('leagueName', $league)
            ->getQuery()
            ->getResult();
    }

    public function getTeamStandings(string $leagueName, int $maxResults = null): array
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t as team')
            ->addSelect('(t.goalsScored - t.goalsConceded) as goals_diff')
            ->leftJoin('t.season', 'ts')
            ->leftJoin('ts.league', 'tsl')
            ->orderBy('t.points', 'DESC')
            ->addOrderBy('goals_diff', 'DESC')
            ->addOrderBy('t.goalsScored', 'DESC')
            ->where('t.season IS NOT NULL')
            ->andWhere('tsl.name = :leagueName')
            ->setParameter('leagueName', $leagueName)
        ;

        if ($maxResults) {
            $qb->setMaxResults($maxResults);
        }

        return $qb->getQuery()->execute();
    }

    public function getTeamStandingsForLeague(League $league, int $maxResults = null): array
    {
        $qb = $this->createQueryBuilder('t')
            ->select('t as team')
            ->addSelect('(t.goalsScored - t.goalsConceded) as goals_diff')
            ->leftJoin('t.season', 'ts')
            ->leftJoin('ts.league', 'tsl')
            ->orderBy('t.points', 'DESC')
            ->addOrderBy('goals_diff', 'DESC')
            ->addOrderBy('t.goalsScored', 'DESC')
            ->where('t.season IS NOT NULL')
            ->andWhere('tsl = :league')
            ->setParameter('league', $league)
        ;

        if ($maxResults) {
            $qb->setMaxResults($maxResults);
        }

        return $qb->getQuery()->execute();
    }
}
