<?php

namespace App\Controller;

use App\Repository\TechnologyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
}