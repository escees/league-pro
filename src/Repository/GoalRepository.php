<?php

namespace App\Repository;

use App\Entity\Goal;
use App\Entity\League;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Goal|null find($id, $lockMode = null, $lockVersion = null)
 * @method Goal|null findOneBy(array $criteria, array $orderBy = null)
 * @method Goal[]    findAll()
 * @method Goal[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoalRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Goal::class);
    }

    public function getBestScorersForTeams(array $teams)
    {
        $qb = $this->createQueryBuilder('g')
            ->select('COUNT(g.id) as goals')
            ->addSelect('s.name as name')
            ->addSelect('t.name as team')
            ->addSelect('t.id as team_id')
            ->leftJoin('g.scorer', 's')
            ->leftJoin('s.team', 't')
            ->where('t IN (:teams)')
            ->setParameter('teams', $teams)
            ->groupBy('s.name, t.name, t.id')
            ->orderBy('goals', 'DESC');

        return $qb->getQuery()->execute();
    }

    public function getBestScorersForLeagueEntity(League $league)
    {
        return $this->createQueryBuilder('g')
            ->select('COUNT(g.id) as goals')
            ->addSelect('s.name as name')
            ->addSelect('t.name as team')
            ->addSelect('t.id as team_id')
            ->leftJoin('g.scorer', 's')
            ->leftJoin('s.team', 't')
            ->leftJoin('t.season', 'ts')
            ->leftJoin('ts.league', 'tsl')
            ->where('tsl = :league')
            ->setParameter('league', $league)
            ->groupBy('s.name, t.name, t.id')
            ->orderBy('goals', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getBestScorersForLeague(string $league)
    {
        return $this->createQueryBuilder('g')
            ->select('COUNT(g.id) as goals')
            ->addSelect('s.name as name')
            ->addSelect('t.name as team')
            ->addSelect('t.id as team_id')
            ->leftJoin('g.scorer', 's')
            ->leftJoin('s.team', 't')
            ->leftJoin('t.season', 'ts')
            ->leftJoin('ts.league', 'tsl')
            ->where('tsl.name = :leagueName')
            ->setParameter('leagueName', $league)
            ->groupBy('s.name, t.name, t.id')
            ->orderBy('goals', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function getBestAssistantsForTeams(array $teams)
    {
        return $this->createQueryBuilder('g')
            ->select('COUNT(g.id) as assists')
            ->addSelect('a.name as name')
            ->addSelect('t.name as team')
            ->addSelect('t.id as team_id')
            ->leftJoin('g.assistant', 'a')
            ->leftJoin('a.team', 't')
            ->where('g.assistant IS NOT NULL')
            ->andWhere('t IN (:teams)')
            ->setParameter('teams', $teams)
            ->groupBy('a.name, t.name, t.id')
            ->orderBy('assists', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function getBestAssistantsForLeague(string $league)
    {
        return $this->createQueryBuilder('g')
            ->select('COUNT(g.id) as assists')
            ->addSelect('a.name as name')
            ->addSelect('t.name as team')
            ->addSelect('t.id as team_id')
            ->leftJoin('g.assistant', 'a')
            ->leftJoin('a.team', 't')
            ->leftJoin('t.season', 'ts')
            ->leftJoin('ts.league', 'tsl')
            ->where('g.assistant IS NOT NULL')
            ->andWhere('tsl.name = :leagueName')
            ->setParameter('leagueName', $league)
            ->groupBy('a.name, t.name, t.id')
            ->orderBy('assists', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function getBestAssistantsForLeagueEntity(League $league)
    {
        return $this->createQueryBuilder('g')
            ->select('COUNT(g.id) as assists')
            ->addSelect('a.name as name')
            ->addSelect('t.name as team')
            ->addSelect('t.id as team_id')
            ->leftJoin('g.assistant', 'a')
            ->leftJoin('a.team', 't')
            ->leftJoin('t.season', 'ts')
            ->leftJoin('ts.league', 'tsl')
            ->where('g.assistant IS NOT NULL')
            ->andWhere('tsl = :league')
            ->setParameter('league', $league)
            ->groupBy('a.name, t.name, t.id')
            ->orderBy('assists', 'DESC')
            ->getQuery()
            ->execute();
    }
}
