<?php

namespace App\Repository;

use App\Entity\Playliste;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Playliste|null find($id, $lockMode = null, $lockVersion = null)
 * @method Playliste|null findOneBy(array $criteria, array $orderBy = null)
 * @method Playliste[]    findAll()
 * @method Playliste[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaylisteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Playliste::class);
    }

    public function findByPlaylist()
    {
        return $this->createQueryBuilder("p")
            ->orderBy("p.id", "DESC")
            ->setMaxResults(9)
            ->getQuery()
            ->getResult();
    }

    public function findLoadMorePlaylist($id)
    {
        return $this->createQueryBuilder("p")
            ->where("p.id < :id")
            ->orderBy("p.id", "DESC")
            ->setParameter("id", $id)
            ->setMaxResults(6)
            ->getQuery()->getResult();
    }
}
