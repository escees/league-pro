<?php

namespace App\Repository;

use App\Entity\ManOfTheMatch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ManOfTheMatch|null find($id, $lockMode = null, $lockVersion = null)
 * @method ManOfTheMatch|null findOneBy(array $criteria, array $orderBy = null)
 * @method ManOfTheMatch[]    findAll()
 * @method ManOfTheMatch[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ManOfTheMatchRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ManOfTheMatch::class);
    }

    // /**
    //  * @return ManOfTheMatch[] Returns an array of ManOfTheMatch objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ManOfTheMatch
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
