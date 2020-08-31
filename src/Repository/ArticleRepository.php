<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findByLastArticlesHome()
    {
        return $this->createQueryBuilder("a")
            ->orderBy("a.publishedAt", "DESC")
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    public function findByArticles()
    {
        return $this->createQueryBuilder("a")
            ->orderBy("a.publishedAt", "DESC")
            ->setMaxResults(9)
            ->getQuery()
            ->getResult();
    }

    public function findByLastArticles($date)
    {
        return $this->createQueryBuilder("a")
            ->where("a.publishedAt < :date")
            ->orderBy("a.publishedAt", "DESC")
            ->setParameter("date", $date)
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }

    public function findBySearch(string $value)
    {
        return $this->createQueryBuilder("a")
            ->where("a.title LIKE :search")
            ->orWhere("a.description LIKE :search")
            ->setParameter(':search', "%$value%")
            ->getQuery()->getResult();
    }
}
