<?php

namespace App\Controller;

use App\Repository\TechnologyRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class TechnologyController
 * @package App\Controller
 */
class TechnologyController extends AbstractController
{
    /**
     * @Route("/technologies", name="technologies", methods={"GET"})
     * @param TechnologyRepository $technologyRepository
     * @return JsonResponse
     */
    public function technologies(TechnologyRepository $technologyRepository): JsonResponse
    {
        return $this->json(["technologies" => $technologyRepository->findAll()], 200, [], ["groups" => "technologies"]);
    }

    /**
     * @Route("/technology/{slug}/{id}", name="technology", methods={"GET"})
     * @param $id
     * @param string $slug
     * @param TechnologyRepository $technologyRepository
     * @param VideoRepository $videoRepository
     * @return JsonResponse
     */
    public function technology($id, string $slug, TechnologyRepository $technologyRepository, VideoRepository $videoRepository): JsonResponse
    {
        $technology = $technologyRepository->findOneBy(["id" => (int)$id, "slug" => $slug]);
        return $this->json([
            "technology" => $technology,
            "videos" => $videoRepository->findByTechnology($technology),
        ], 200, [], ["groups" => "technology"]);
    }

    /**
     * @Route("/technology/videos/load/more/{id}", name="load_more_video_technology")
     * @param $id
     * @param Request $request
     * @param VideoRepository $videoRepository
     * @param TechnologyRepository $technologyRepository
     * @return JsonResponse
     * @throws \Exception
     */
    public function loadMoreVideoTechnology($id, Request $request, VideoRepository $videoRepository,
                                            TechnologyRepository $technologyRepository): JsonResponse
    {
        $date = new \DateTime($request->request->get("date"));
        $technology = $technologyRepository->findOneBy(['id' => (int)$id]);
        return $this->json($videoRepository->findByLoadMoreTechnologyVideo($date, $technology), 200, [], ["groups" => "technology"]);
    }
}