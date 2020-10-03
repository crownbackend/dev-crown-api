<?php

namespace App\Controller;

use App\Repository\PlaylisteRepository;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class PlaylistController
 * @package App\Controller
 */
class PlaylistController extends AbstractController
{
    /**
     * @Route("/playlists", name="playlists", methods={"GET"})
     * @param PlaylisteRepository $playlisteRepository
     * @return JsonResponse
     */
    public function playlists(PlaylisteRepository $playlisteRepository): JsonResponse
    {
        return $this->json(["playlists" => $playlisteRepository->findByPlaylist()],
            200, [], ["groups" => "playlists"]);
    }

    /**
     * @Route("/playlists/load/more/{id}", name="load_more_playlist", methods={"GET"})
     * @param $id
     * @param PlaylisteRepository $playlisteRepository
     * @return JsonResponse
     */
    public function loadMorePlaylists($id, PlaylisteRepository $playlisteRepository): JsonResponse
    {
        return $this->json($playlisteRepository->findLoadMorePlaylist($id), 200, [], ["groups" => "playlists"]);
    }

    /**
     * @Route("/playlist/{slug}/{id}", name="show_playlist", methods={"GET"})
     * @param string $slug
     * @param $id
     * @param PlaylisteRepository $playlisteRepository
     * @param Request $request
     * @param VideoRepository $videoRepository
     * @param JWTEncoderInterface $JWTEncoder
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function show(string $slug, $id, PlaylisteRepository $playlisteRepository,Request $request,
                         VideoRepository $videoRepository, JWTEncoderInterface $JWTEncoder,
                         UserRepository $userRepository): JsonResponse
    {
        $playlist = $playlisteRepository->findOneBy(["slug" => $slug, "id" => (int)$id]);
        return $this->favoredVideoPlaylist($request, $JWTEncoder, $userRepository,
            $videoRepository->findByPlaylistVideos($playlist), $playlist);
    }

    /**
     * @Route("/playlist/videos/load/more/{id}", name="load_more_playlist_video", methods={"POST"})
     * @param $id
     * @param VideoRepository $videoRepository
     * @param UserRepository $userRepository
     * @param PlaylisteRepository $playlisteRepository
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function loadMorePlaylistVideos($id, VideoRepository $videoRepository, UserRepository $userRepository,
                                            PlaylisteRepository $playlisteRepository, Request $request,
                                           JWTEncoderInterface $JWTEncoder): JsonResponse
    {
        $playlist = $playlisteRepository->findOneBy(["id" => $id]);
        return $this->favoredVideoPlaylist($request, $JWTEncoder, $userRepository,
            $videoRepository->findByLoadMorePlaylistVideos($request->request->get("date"), $playlist), $playlist);
    }

    /**
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param UserRepository $userRepository
     * @param $repository
     * @param $playlist
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    private function favoredVideoPlaylist(Request $request, JWTEncoderInterface $JWTEncoder,
                                          UserRepository $userRepository, $repository, $playlist)
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
                return $this->json([
                    "playlist" => $playlist,
                    "videos" => $repository
                ], 200, [], ["groups" => "playlist"]);
            }
        } else {
            return $this->json([
                "playlist" => $playlist,
                "videos" => $repository
            ], 200, [], ["groups" => "playlist"]);
        }
    }
}