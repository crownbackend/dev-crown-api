<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Video::class);
    }

    public function findByVideos()
    {
        return $this->createQueryBuilder("v")
            ->orderBy("v.publishedAt", "DESC")
            ->setMaxResults(9)
            ->getQuery()
            ->getResult();
    }

    public function findByLastVideos()
    {
        return $this->createQueryBuilder("v")
            ->orderBy("v.publishedAt", "DESC")
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function findByLoadMoreVideo($date)
    {
        return $this->createQueryBuilder('v')
            ->where('v.publishedAt < :date')
            ->setParameter('date', $date)
            ->orderBy('v.publishedAt', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }

}
