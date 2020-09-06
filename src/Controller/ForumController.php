<?php


namespace App\Controller;


use App\Repository\ForumRepository;
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

    public function __construct(ForumRepository $forumRepository)
    {
        $this->forumRepository = $forumRepository;
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
     * @Route("/forum/{id}", name="forum", methods={"GET"})
     * @param $id
     * @return JsonResponse
     */
    public function forum($id): JsonResponse
    {
        return $this->json($this->forumRepository->findOneBy(["id" => $id]), 200, [], ["groups" => "forum"]);
    }
}