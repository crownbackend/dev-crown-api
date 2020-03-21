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

    // /**
    //  * @return Playliste[] Returns an array of Playliste objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Playliste
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
