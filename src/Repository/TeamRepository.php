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

    public function getTeamStandings(): array
    {
        return $this->createQueryBuilder('t')
            ->select('t.points')
            ->addSelect('t.id')
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
            ->addOrderBy('t.goalsScored', 'DESC')
            ->getQuery()
            ->execute()
        ;
    }
}
