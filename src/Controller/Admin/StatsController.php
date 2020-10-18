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
     * @Route("/forums", name="forums_stats", methods={"GET"})
     * @param Request $request
     * @return JsonResponse
     */
    public function forumStats(Request $request): JsonResponse
    {
        function random_color_part() {
            return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
        }
        function random_color() {
            return '#'.random_color_part() . random_color_part() . random_color_part();
        }
        if($request->isXmlHttpRequest()) {
            $label = [];
            $numberTopic = [];
            $color = [];
            foreach ($this->forumRepository->findAll() as $forum) {
                array_push($label, $forum->getName());
                array_push($numberTopic, count($forum->getTopics()));
                array_push($color, random_color());
            }
            $resultat['label'] = $label;
            $resultat['numberTopic'] = $numberTopic;
            $resultat['color'] = $color;
            return $this->json($resultat);
        } else {
            return $this->json(["not access" => 1], 403);
        }
    }
}