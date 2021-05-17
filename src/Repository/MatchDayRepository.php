<?php

namespace App\Repository;

use App\Entity\MatchDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method MatchDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method MatchDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method MatchDay[]    findAll()
 * @method MatchDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchDayRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, MatchDay::class);
    }

    public function findAllOrderByDateDescendant()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.startDate', 'DESC')
            ->getQuery()
            ->execute();
    }

    public function findAllOrderByDateAscending(string $league)
    {
        return $this->createQueryBuilder('m')
            ->leftJoin('m.matches', 'r')
            ->leftJoin('r.matchDetails', 'rm')
            ->leftJoin('r.homeTeam', 't')
            ->leftJoin('t.season', 's')
            ->leftJoin('s.league', 'l')
            ->setParameter('leagueName', $league)
            ->where('m.startDate <= :now AND m.endDate >= :now')
            ->orWhere('m.startDate > :now')
            ->andWhere('l.name = :leagueName')
            ->setParameter('now', new \DateTime())
            ->orderBy('m.startDate', 'ASC')
            ->getQuery()
            ->execute();
    }

    public function getAllResultsForLeague(string $league)
    {
        return $this->createQueryBuilder('m')
            ->select('m')
            ->addSelect('r')
            ->addSelect('rm')
            ->leftJoin('m.matches', 'r')
            ->leftJoin('r.matchDetails', 'rm')
            ->leftJoin('r.homeTeam', 't')
            ->leftJoin('t.season', 's')
            ->leftJoin('s.league', 'l')
            ->where('r.matchDetails IS NOT NULL')
            ->andWhere('l.name = :leagueName')
            ->setParameter('leagueName', $league)
            ->orderBy('m.startDate', 'DESC')
            ->getQuery()
            ->execute();
    }
}
