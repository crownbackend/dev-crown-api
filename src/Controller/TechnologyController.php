<?php

namespace App\Controller;

use App\Repository\TechnologyRepository;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
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
        return $this->json(["technologies" => $technologyRepository->findByTechnologies()],
            200, [], ["groups" => "technologies"]);
    }

    /**
     * @Route("/technology/{slug}/{id}", name="technology", methods={"GET"})
     * @param $id
     * @param string $slug
     * @param TechnologyRepository $technologyRepository
     * @param VideoRepository $videoRepository
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function technology($id, string $slug, TechnologyRepository $technologyRepository,
                               VideoRepository $videoRepository, Request $request,
                               JWTEncoderInterface $JWTEncoder, UserRepository $userRepository): JsonResponse
    {
        $technology = $technologyRepository->findOneBy(["id" => (int)$id, "slug" => $slug]);
        return $this->favoredVideoTechnology($request, $JWTEncoder, $userRepository,
            $videoRepository->findByTechnology($technology), $technology);
    }

    /**
     * @Route("/technologies/load/more/{id}", name="load_last_more_technology", methods={"GET"})
     * @param $id
     * @param TechnologyRepository $technologyRepository
     * @return JsonResponse
     */
    public function loadLastMoreTechnologies($id, TechnologyRepository $technologyRepository): JsonResponse
    {
        return $this->json($technologyRepository->findByLoadMoreTechnologies($id),
            200, [], ["groups" => "technology"]);
    }

    /**
     * @Route("/technology/videos/load/more/{id}", name="load_more_video_technology", methods={"POST"})
     * @param $id
     * @param Request $request
     * @param VideoRepository $videoRepository
     * @param TechnologyRepository $technologyRepository
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function loadMoreVideoTechnology($id, Request $request, VideoRepository $videoRepository,
                                            TechnologyRepository $technologyRepository,
                                            JWTEncoderInterface $JWTEncoder, UserRepository $userRepository): JsonResponse
    {
        $date = new \DateTime($request->request->get("date"));
        $technology = $technologyRepository->findOneBy(['id' => (int)$id]);
        return $this->favoredVideoTechnology($request, $JWTEncoder, $userRepository,
            $videoRepository->findByLoadMoreTechnologyVideo($date, $technology), $technology);
    }

    private function favoredVideoTechnology(Request $request, JWTEncoderInterface $JWTEncoder,
                                            UserRepository $userRepository, $repository, $technology)
    {
        if($request->headers->get("authorization")) {
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
                    "technology" => $technology,
                    "videos" => $repository,
                ], 200, [], ["groups" => "technology"]);
            }
        } else {
            return $this->json([
                "technology" => $technology,
                "videos" => $repository,
            ], 200, [], ["groups" => "technology"]);
        }
    }
}