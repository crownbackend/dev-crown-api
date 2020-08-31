<?php

namespace App\Repository;

use App\Entity\CommentVideo;
use App\Entity\Video;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CommentVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method CommentVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method CommentVideo[]    findAll()
 * @method CommentVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CommentVideo::class);
    }

    public function findByCommentsByVideo(Video $video)
    {
        return $this->createQueryBuilder("c")
            ->where("c.video = :video")
            ->orderBy("c.createdAt", "DESC")
            ->setParameter("video", $video)
            ->getQuery()
            ->getResult();
    }
}
