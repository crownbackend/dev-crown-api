<?php


namespace App\Controller;


use App\Repository\ForumRepository;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class ForumController
 * @package App\Controller
 */
class ForumController extends AbstractController
{
    /**
     * @var ForumRepository
     */
    private $forumRepository;
    /**
     * @var TopicRepository
     */
    private $topicRepository;

    public function __construct(ForumRepository $forumRepository, TopicRepository $topicRepository)
    {
        $this->forumRepository = $forumRepository;
        $this->topicRepository = $topicRepository;
    }

    /**
     * @Route("/forum", name="forums", methods={"GET"})
     * @return JsonResponse
     */
    public function forums(): JsonResponse
    {
        return $this->json(["forums" => $this->forumRepository->findAll()], 200, [], ["groups" => "forums"]);
    }

    /**
     * @Route("/forum/{id}/{slug}", name="forum", methods={"GET"})
     * @param $id
     * @param $slug
     * @return JsonResponse
     */
    public function forum($id, $slug): JsonResponse
    {
        return $this->json(["forum" => $this->forumRepository->findOneBy(["id" => $id, "slug" => $slug]),
            "topics" => $this->topicRepository->findByForumTopics($id)],
            200, [], ["groups" => "forum"]);
    }

    /**
     * @Route("/forums/category/list", name="forum_category_list", methods={"GET"})
     * @return JsonResponse
     */
    public function forumCategoryList(): JsonResponse
    {
        return $this->json($this->forumRepository->findAll(), 200, [], ["groups" => "forumList"]);
    }
}