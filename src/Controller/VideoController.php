<?php

namespace App\Controller;

use App\Repository\VideoRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\StreamedResponse;
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
    public function video($slug, $id, VideoRepository $videoRepository): JsonResponse
    {
        return $this->json([ "video" => $videoRepository->findOneBy(["slug" => $slug, "id" => (int)$id]) ], 200, [], ["groups" => "video"]);
    }

    /**
     * @Route("/check/download/video", name="check_download_video", methods={"POST"})
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function checkDownloadVideo(Request $request, JWTEncoderInterface $JWTEncoder): JsonResponse
    {
        $tokenValid = $JWTEncoder->decode(json_decode($request->getContent(), true)["authorization"]);
        if($tokenValid['username']) {
            return $this->json(["download" => 1]);
        } else {
            return $this->json("error", 500);
        }
    }

    /**
     * @Route("/file/{name}", name="download_video")
     * @param string $name
     * @return Response
     */
    public function downloadVideo(string $name): Response
    {
        return $this->render("download/video-download.html.twig", [
            "name" => $name
        ]);
    }
}