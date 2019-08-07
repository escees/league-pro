<?php

namespace App\Repository;

use App\Entity\Goal;
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

    public function getBestScorers()
    {
        return $this->createQueryBuilder('g')
            ->select('COUNT(g.id) as goals')
            ->addSelect('s.name as name')
            ->addSelect('t.name as team')
            ->leftJoin('g.scorer', 's')
            ->leftJoin('s.team', 't')
            ->groupBy('s.name, t.name')
            ->orderBy('goals', 'DESC')
            ->getQuery()
            ->execute()
            ;
    }

    public function getBestAssistants()
    {
        return $this->createQueryBuilder('g')
            ->select('COUNT(g.id) as assists')
            ->addSelect('a.name as name')
            ->addSelect('t.name as team')
            ->leftJoin('g.assistant', 'a')
            ->leftJoin('a.team', 't')
            ->where('g.assistant IS NOT NULL')
            ->groupBy('a.name, t.name')
            ->orderBy('assists', 'DESC')
            ->getQuery()
            ->execute()
            ;
    }
}
