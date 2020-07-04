<?php

namespace App\Repository;

use App\Entity\News;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, News::class);
    }

    public function findPublishedNews(int $maxResults): array
    {
        return $this->createQueryBuilder('n')
            ->where('n.published = 1')
            ->setMaxResults($maxResults)
            ->orderBy('n.createdAt', 'DESC')
            ->getQuery()
            ->execute();
    }
}
