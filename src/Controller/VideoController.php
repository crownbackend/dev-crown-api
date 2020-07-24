<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function videos(VideoRepository $videoRepository, Request $request,
                           JWTEncoderInterface $JWTEncoder, UserRepository $userRepository): JsonResponse
    {
        return $this->videosFavored($request, $JWTEncoder, $userRepository, $videoRepository->findByVideos());
    }

    /**
     * @Route("/videos/load/more", name="load_video", methods={"POST"})
     * @param VideoRepository $videoRepository
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function loadVideo(VideoRepository $videoRepository, Request $request,
                              JWTEncoderInterface $JWTEncoder, UserRepository $userRepository): JsonResponse
    {
        $date = new \DateTime($request->request->get("date"));
        return $this->videosFavored($request, $JWTEncoder, $userRepository,
            $videoRepository->findByLoadMoreVideo($date->format('Y-m-d H:i:s')));
    }

    /**
     * @Route("/last/videos", name="videos_last", methods={"GET"})
     * @param VideoRepository $videoRepository
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function lastVideos(VideoRepository $videoRepository, Request $request,
                               JWTEncoderInterface $JWTEncoder, UserRepository $userRepository): JsonResponse
    {

        return $this->videosFavored($request, $JWTEncoder, $userRepository, $videoRepository->findByLastVideos());
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
        return $this->json([ "video" => $videoRepository->findOneBy(["slug" => $slug, "id" => (int)$id]) ],
            200, [], ["groups" => "video"]);
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
     * @Route("/file/{name}/{token}", name="download_video")
     * @param string $name
     * @param string $token
     * @param JWTEncoderInterface $JWTEncoder
     * @return Response
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function downloadVideo(string $name, string $token, JWTEncoderInterface $JWTEncoder): Response
    {
        $tokenValid = $JWTEncoder->decode($token);
        if($tokenValid) {
            return $this->render("download/video-download.html.twig", [
                "name" => $name
            ]);
        } else {
            return $this->redirect($this->getParameter("host_front"));
        }
    }

    /**
     * @Route("/videos/add/favored", name="video_favored_add", methods={"POST"})
     * @param Request $request
     * @param VideoRepository $videoRepository
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function addFavored(Request $request, VideoRepository $videoRepository,
                               UserRepository $userRepository): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $video = $videoRepository->findOneBy(['id' => $request->request->get('videoId')]);
        $user  = $userRepository->findOneBy(['id' => $request->request->get('userId')]);
        $video->addUser($user);
        $em->persist($video);
        $em->flush();
        return $this->json(['success' => 1]);
    }

    /**
     * @Route("/videos/remove/favored", name="video_favored_remove", methods={"POST"})
     * @param Request $request
     * @param VideoRepository $videoRepository
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function removeFavored(Request $request, VideoRepository $videoRepository,
                                  UserRepository $userRepository): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $video = $videoRepository->findOneBy(['id' => $request->request->get('videoId')]);
        $user  = $userRepository->findOneBy(['id' => $request->request->get('userId')]);
        $video->removeUser($user);
        $em->persist($video);
        $em->flush();
        return $this->json(['success' => 1]);
    }

    /**
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param UserRepository $userRepository
     * @param $repository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    private function videosFavored(Request $request, JWTEncoderInterface $JWTEncoder,
                                   UserRepository $userRepository, $repository)
    {
        if($request->headers->get('authorization')) {
            $tokenValid = $JWTEncoder->decode($request->headers->get('authorization'));
            if($tokenValid) {
                $userFav = $userRepository->findOneBy(['username' => $tokenValid['username']]);
                foreach ($repository as $video) {
                    foreach ($video->getUsers() as $user) {
                        if($user->getId() == $userFav->getId()) {
                            $video->favored = 1;
                        }
                    }
                }
                return $this->json(["videos" => $repository], 200, [], ["groups" => "videos"]);
            }
        } else {
            return $this->json(["videos" => $repository], 200, [], ["groups" => "videos"]);
        }
    }
}