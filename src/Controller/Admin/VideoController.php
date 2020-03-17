<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/back-office/dev-crown")
 * Class VideoController
 * @package App\Controller\Admin
 */
class VideoController extends AbstractController
{
    /**
     * @Route("/videos/", name="admin_video")
     * @param VideoRepository $videoRepository
     * @return Response
     */
    public function index( VideoRepository $videoRepository): Response
    {
        return $this->render("video/index.html.twig", [
            "videos" => $videoRepository->findAll()
        ]);
    }

    /**
     * @Route("/video/new", name="admin_video_new")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $video->setImageFile($imageFileName);
            }
            $em = $this->getDoctrine()->getManager();

            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute("admin_video");
        }
        return $this->render('video/new.html.twig', [
            "form" => $form->createView()
        ]);
    }
}