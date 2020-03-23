<?php

namespace App\Controller;

use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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

    /**
     * @Route("/last/videos", name="videos_last", methods={"GET"})
     * @param VideoRepository $videoRepository
     * @return JsonResponse
     */
    public function lastVideos(VideoRepository $videoRepository): JsonResponse
    {
        return $this->json(["videos" => $videoRepository->findByLastVideos()], 200, [], ["groups" => "lastVideos"]);
    }

    /**
     * @Route("/video/{slug}/{id}", name="video", methods={"GET"})
     * @param string $slug
     * @param int $id
     * @param VideoRepository $videoRepository
     * @return JsonResponse
     */
    public function video($slug, $id, VideoRepository $videoRepository, Request $request): JsonResponse
    {
        return $this->json([ "video" => $videoRepository->findOneBy(["slug" => $slug, "id" => (int)$id]) ], 200, [], ["groups" => "video"]);
    }
}