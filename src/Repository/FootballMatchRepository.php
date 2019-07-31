<?php

namespace App\Repository;

use App\Entity\FootballMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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

    public function getAllFixturesOrderedByStartDateAscending()
    {
        return $this->createQueryBuilder('m')
            ->where('m.startDate > :now')
            ->orderBy('m.startDate', 'ASC')
            ->setParameter('now', new \Datetime())
            ->setMaxResults(15)
            ->getQuery()
            ->execute();
    }

    public function getAllPlayedMatchesOrderedByStartDateDescending()
    {
        return $this->createQueryBuilder('m')
            ->where('m.startDate < :now')
            ->orderBy('m.startDate', 'DESC')
            ->setParameter('now', new \Datetime())
            ->setMaxResults(15)
            ->getQuery()
            ->execute();
    }
}
