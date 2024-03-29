<?php

namespace App\Repository;

use App\Entity\FootballMatch;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FootballMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method FootballMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method FootballMatch[]    findAll()
 * @method FootballMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FootballMatchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FootballMatch::class);
    }

    public function getNextMatch(): ?FootballMatch
    {
        return $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.startDate > :now')
            ->orderBy('m.startDate', 'ASC')
            ->setParameter('now', new \Datetime())
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getAllFixtures()
    {
        return $this->createQueryBuilder('m')
            ->where('m.startDate > :now')
            ->orderBy('m.startDate', 'ASC')
            ->setParameter('now', new \Datetime())
            ->getQuery()
            ->execute();
    }

    public function getNumberOfFixturesOrderedByStartDateAscending(int $number)
    {
        return $this->createQueryBuilder('m')
            ->select('m as match')
            ->addSelect('tsl.name as league_name')
            ->leftJoin('m.homeTeam', 't')
            ->leftJoin('t.season', 'ts')
            ->leftJoin('ts.league', 'tsl')
            ->where('t.season IS NOT NULL')
            ->where('m.startDate > :now')
            ->orderBy('m.startDate', 'ASC')
            ->setParameter('now', new \Datetime())
            ->setMaxResults($number)
            ->getQuery()
            ->execute();
    }

    public function getAllFixturesByTeam(Team $team)
    {
        return $this->createQueryBuilder('m')
            ->where('m.startDate > :now')
            ->andWhere('m.homeTeam = :team OR m.awayTeam = :team')
            ->orderBy('m.startDate', 'ASC')
            ->setParameters([
                'now' => new \Datetime(),
                'team' => $team
            ])
            ->setMaxResults(16)
            ->getQuery()
            ->execute();
    }

    public function getAllPlayedMatchesOrderedByStartDateDescending()
    {
        return $this->createQueryBuilder('m')
            ->where('m.startDate < :now')
            ->orderBy('m.startDate', 'DESC')
            ->setParameter('now', new \Datetime())
            ->setMaxResults(16)
            ->getQuery()
            ->execute();
    }

    public function getAllResultsOrderedByStartDateDescending()
    {
        return $this->createQueryBuilder('m')
            ->where('m.startDate < :now')
            ->andWhere('m.matchDetails IS NOT NULL')
            ->orderBy('m.startDate', 'DESC')
            ->setParameter('now', new \Datetime())
            ->getQuery()
            ->execute();
    }

    public function getLastThreeMatches()
    {
        return $this->createQueryBuilder('m')
            ->where('m.startDate < :now')
            ->andWhere('m.matchDetails IS NOT NULL')
            ->orderBy('m.startDate', 'DESC')
            ->setParameter('now', new \Datetime())
            ->setMaxResults(3)
            ->getQuery()
            ->execute();
    }

    public function getLastThreeMatchesForLeague(string $league)
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.homeTeam', 't')
            ->leftJoin('t.season', 's')
            ->leftJoin('s.league', 'l')
            ->where('m.startDate < :now')
            ->andWhere('m.matchDetails IS NOT NULL')
            ->andWhere('l.name = :leagueName')
            ->orderBy('m.startDate', 'DESC')
            ->setParameters(['now' => new \Datetime(), 'leagueName' => $league])
            ->setMaxResults(3)
            ->getQuery()
            ->execute();
    }

    public function getAllResultsOrderedByStartDateDescendingByTeam(Team $team)
    {
        return $this->createQueryBuilder('m')
            ->where('m.startDate < :now')
            ->andWhere('m.homeTeam = :team OR m.awayTeam = :team')
            ->andWhere('m.matchDetails IS NOT NULL')
            ->orderBy('m.startDate', 'DESC')
            ->setParameters([
                'now' => new \Datetime(),
                'team' => $team
            ])
            ->setMaxResults(16)
            ->getQuery()
            ->execute();
    }
}
