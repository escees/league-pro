<?php

namespace App\Repository;

use App\Entity\FootballMatch;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FootballMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method FootballMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method FootballMatch[]    findAll()
 * @method FootballMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FootballMatchRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FootballMatch::class);
    }

    public function getNextMatch()
    {
        return $this->createQueryBuilder('m')
            ->select('m')
            ->where('m.startDate > :now')
            ->orderBy('m.startDate', 'ASC')
            ->setParameter('now', new \Datetime())
            ->setMaxResults(1)
            ->getQuery()
            ->getSingleResult();
    }

    public function getNumberOfFixturesOrderedByStartDateAscending(int $number)
    {
        return $this->createQueryBuilder('m')
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
            ->andWhere('m.matchDetails IS NOT NULL')
            ->orderBy('m.startDate', 'DESC')
            ->setParameter('now', new \Datetime())
            ->setMaxResults(16)
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
