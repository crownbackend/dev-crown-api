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
     * @Route("/last/topics", name="last_topics", methods={"GET"})
     * @param TopicRepository $topicRepository
     * @return JsonResponse
     */
    public function topics(TopicRepository $topicRepository): JsonResponse
    {
        return $this->json(["topics" => $topicRepository->findByLastTopic()], 200, [], ["groups" => "lastTopics"]);
    }
}