<?php

namespace App\Controller;

use App\Repository\PlaylisteRepository;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @param VideoRepository $videoRepository
     * @return JsonResponse
     */
    public function show(string $slug, $id, PlaylisteRepository $playlisteRepository,
                         VideoRepository $videoRepository): JsonResponse
    {
        $playlist = $playlisteRepository->findOneBy(["slug" => $slug, "id" => (int)$id]);
        return $this->json([
            "playlist" => $playlist,
            "videos" => $videoRepository->findByPlaylistVideos($playlist)
        ], 200, [], ["groups" => "playlist"]);
    }
}