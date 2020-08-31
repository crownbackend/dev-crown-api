<?php

namespace App\Repository;

use App\Entity\Technology;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Technology|null find($id, $lockMode = null, $lockVersion = null)
 * @method Technology|null findOneBy(array $criteria, array $orderBy = null)
 * @method Technology[]    findAll()
 * @method Technology[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TechnologyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Technology::class);
    }

    public function findByTechnologies()
    {
        return $this->createQueryBuilder("t")
            ->orderBy("t.id", "ASC")
            ->setMaxResults(9)
            ->getQuery()
            ->getResult();
    }
    public function findByLoadMoreTechnologies($id)
    {
        return $this->createQueryBuilder("t")
            ->where("t.id > :id")
            ->setParameter("id", $id)
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }
}
