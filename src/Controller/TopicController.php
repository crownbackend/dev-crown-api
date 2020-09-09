<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class TopicController
 * @package App\Controller
 */
class TopicController extends AbstractController
{
    /**
     * @var TopicRepository
     */
    private $topicRepository;

    public function __construct(TopicRepository $topicRepository)
    {
        $this->topicRepository = $topicRepository;
    }

    /**
     * @Route("/topic/{id}/{slug}", name="topic", methods={"GET"})
     * @param $slug
     * @param $id
     * @return JsonResponse
     */
    public function topic($slug, $id): JsonResponse
    {
        return $this->json(["topic" => $this->topicRepository->findOneBy(["id" => $id, "slug" => $slug])],
            200, [], ["groups" => "topic"]);
    }

    /**
     * @Route("/last/topics", name="last_topics", methods={"GET"})
     * @return JsonResponse
     */
    public function topics(): JsonResponse
    {
        return $this->json(["topics" => $this->topicRepository->findByLastTopic()],
            200, [], ["groups" => "lastTopics"]);
    }

    /**
     * @Route("/topics/show/more/{date}/{id}", name="load_topics", methods={"GET"})
     * @param $date
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function topicsShowMore($date, $id): JsonResponse
    {
        $d = new \DateTime($date);
        return $this->json(["topics" => $this->topicRepository->findByLoadMoreTopics($d->format("Y-m-d H:i:s"),
            $id)], 200, [], ["groups" => "topicsMore"]);
    }
}