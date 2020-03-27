<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class ArticleController
 * @package App\Controller
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/articles", name="articles", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function articles(ArticleRepository $articleRepository): JsonResponse
    {
        return $this->json(["articles" => $articleRepository->findByArticles()], 200, [], ["groups" => "articles"]);
    }

    /**
     * @Route("/last/articles", name="last_articles", methods={"GET"})
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function lastArticles(ArticleRepository $articleRepository): JsonResponse
    {
        return $this->json(["articles" => $articleRepository->findByLastArticles()], 200, [], ["groups" => "articles"]);
    }

    /**
     * @Route("/article/{slug}/{id}", name="article", methods={"GET"})
     * @param string $slug
     * @param $id
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     */
    public function article(string $slug, $id, ArticleRepository $articleRepository): JsonResponse
    {
        return $this->json($articleRepository->findOneBy(["slug" => $slug, "id" => (int)$id]), 200, [], ["groups" => "article"]);
    }
}