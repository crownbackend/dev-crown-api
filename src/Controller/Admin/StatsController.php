<?php

namespace App\Controller\Admin;

use App\Repository\ForumRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/stats")
 * Class StatsController
 * @package App\Controller\Admin
 */
class StatsController extends AbstractController
{
    /**
     * @var ForumRepository
     */
    private $forumRepository;

    public function __construct(ForumRepository $forumRepository)
    {
        $this->forumRepository = $forumRepository;
    }

    /**
     * @Route("/forums")
     * @param Request $request
     * @return JsonResponse
     */
    public function forumStats(Request $request): JsonResponse
    {
        if($request->isXmlHttpRequest()) {
            $forums = $this->forumRepository->findAll();
            return $this->json($forums, 200, [], ["groups" => "forumStats"]);
        } else {
            return $this->json(["not access" => 1], 403);
        }
    }
}