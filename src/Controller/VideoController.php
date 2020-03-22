<?php

namespace App\Controller;

use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class VideoController
 * @package App\Controller
 */
class VideoController extends AbstractController
{
    /**
     * @Route("/videos", name="videos", methods={"GET"})
     * @param VideoRepository $videoRepository
     * @return JsonResponse
     */
    public function videos(VideoRepository $videoRepository): JsonResponse
    {
        return $this->json(["videos" => $videoRepository->findByVideos()], 200, [], ["groups" => "videos"]);
    }
}