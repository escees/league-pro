<?php

namespace App\Repository;

use App\Entity\Player;
use App\Entity\Team;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Player::class);
    }

    public function findPlayersForTeamsParticipatingInMatchQueryBuilder(Team $homeTeam, Team $awayTeam): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->where('p.team = :homeTeam')
            ->orWhere('p.team = :awayTeam')
            ->setParameters(
                [
                    'homeTeam' => $homeTeam,
                    'awayTeam' => $awayTeam
                ]
            );
    }
}
