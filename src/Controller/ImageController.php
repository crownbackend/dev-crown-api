<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class ImageController
 * @package App\Controller
 */
class ImageController extends AbstractController
{
    /**
     * @Route("/images/upload", name="upload_images", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function uploadImages(Request $request): JsonResponse
    {
        return $this->json($request);
    }
}