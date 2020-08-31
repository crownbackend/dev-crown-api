<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\CommentArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentArticle[]    findAll()
 * @method CommentArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentArticle::class);
    }

    public function findByCommentArticle(Article $article)
    {
        return $this->createQueryBuilder("ca")
            ->where("ca.article = :article")
            ->orderBy("ca.createdAt", "DESC")
            ->setParameter("article", $article)
            ->getQuery()
            ->getResult();
    }
}
