<?php

namespace App\Repository;

use App\Entity\Topic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findAll()
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }

    public function findByLastTopic()
    {
        return $this->createQueryBuilder("t")
            ->orderBy("t.createdAt", "DESC")
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();
    }

    public function findBySearch(string $value)
    {
        return $this->createQueryBuilder("t")
            ->where("t.title LIKE :search")
            ->orWhere("t.description LIKE :search")
            ->setParameter(':search', "%$value%")
            ->getQuery()->getResult();
    }

    public function findByForumTopics($id)
    {
        return $this->createQueryBuilder("t")
            ->where("t.forum = :id")
            ->orderBy("t.createdAt", "DESC")
            ->setParameter("id", $id)
            ->setMaxResults(10)
            ->getQuery()->getResult();
    }

    public function findByLoadMoreTopics($date, $id)
    {
        return $this->createQueryBuilder("t")
            ->where("t.forum = :id")
            ->andWhere("t.createdAt < :date ")
            ->orderBy("t.createdAt", "DESC")
            ->setParameters(["date" => $date, "id" => $id])
            ->setMaxResults(10)
            ->getQuery()->getResult();
    }

    public function findTopicsResponsesByUser($user)
    {
        return $this->createQueryBuilder("t")
            ->join("t.responses", "responses")
            ->where("responses.user = :user")
            ->setParameter("user", $user)
            ->getQuery()->getResult();
    }
}
