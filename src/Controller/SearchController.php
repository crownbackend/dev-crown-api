<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\TopicRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class SearchController
 * @package App\Controller
 */
class SearchController extends AbstractController
{
    /**
     * @Route("/search/{search}", name="search", methods={"GET"})
     * @param VideoRepository $videoRepository
     * @param ArticleRepository $articleRepository
     * @param TopicRepository $topicRepository
     * @param $search
     * @return JsonResponse
     */
    public function search(VideoRepository $videoRepository, ArticleRepository $articleRepository,
                           TopicRepository $topicRepository, $search):JsonResponse
    {
        $videos = $videoRepository->findBySearch($search);
        $articles = $articleRepository->findBySearch($search);
        $topics = $topicRepository->findBySearch($search);
        return $this->json(["videos" => $videos, "articles" => $articles, "topics" => $topics],
            200, [], ["groups" => "search"]);
    }
}