<?php

namespace App\Repository;

use App\Entity\Playliste;
use App\Entity\Technology;
use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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

    public function findByTechnology(Technology $technology)
    {
        return $this->createQueryBuilder("v")
            ->where("v.technology = :technology")
            ->orderBy('v.publishedAt', 'DESC')
            ->setParameter("technology", $technology)
            ->setMaxResults(9)
            ->getQuery()
            ->getResult();
    }

    public function findByLoadMoreTechnologyVideo($date, Technology $technology)
    {
        return $this->createQueryBuilder("v")
            ->where("v.technology = :technology")
            ->andWhere("v.publishedAt < :date")
            ->orderBy('v.publishedAt', 'DESC')
            ->setParameters(["technology" => $technology, "date" => $date])
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();

    }

    public function findByPlaylistVideos(Playliste $playlist)
    {
        return $this->createQueryBuilder("v")
            ->where("v.playliste = :playlist")
            ->orderBy("v.publishedAt", "DESC")
            ->setParameter("playlist", $playlist)
            ->setMaxResults(9)
            ->getQuery()
            ->getResult();
    }

    public function findByLoadMorePlaylistVideos($date, Playliste $playlist)
    {
        return $this->createQueryBuilder("v")
            ->where("v.playliste = :playlist")
            ->andWhere("v.publishedAt < :date")
            ->orderBy('v.publishedAt', 'DESC')
            ->setParameters(["playlist" => $playlist, "date" => $date])
            ->setMaxResults(6)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBySearch(string $value)
    {
        return $this->createQueryBuilder("v")
            ->where("v.title LIKE :search")
            ->orWhere("v.description LIKE :search")
            ->setParameter(':search', "%$value%")
            ->getQuery()->getResult();
    }

    public function findVideoByUser($id)
    {
        return $this->createQueryBuilder("v")
            ->join("v.users", "u")
            ->where("u.id = :id")
            ->setParameter("id", $id)
            ->getQuery()->getResult();
    }

}
