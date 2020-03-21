<?php

namespace App\Controller\Admin;

use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/back-office/dev-crown/videos")
 * Class VideoController
 * @package App\Controller\Admin
 */
class VideoController extends AbstractController
{
    /**
     * @Route("/", name="admin_video")
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
     * @Route("/{id}/show", name="admin_video_show")
     * @param Video $video
     * @return Response
     */
    public function show(Video $video): Response
    {
        return $this->render('video/show.html.twig', [
            "video" => $video
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
        $em = $this->getDoctrine()->getManager();
        $video = new Video();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile);
                $video->setImageFile($imageFileName);
            }
            $em->persist($video);
            $em->flush();

            return $this->redirectToRoute("admin_video");
        }
        return $this->render('video/new.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_video_edit")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param Video $video
     * @return Response
     */
    public function edit(Request $request, Video $video, FileUploader $fileUploader): Response
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(VideoType::class, $video);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile, $video->getImageFile(), 'image_directory', 1);
                $video->setImageFile($imageFileName);
            }
            $em->flush();
            return  $this->redirectToRoute('admin_video');
        }
        return $this->render('video/edit.html.twig', [
            "form" => $form->createView(),
            "video" => $video
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_video_delete")
     * @param FileUploader $fileUploader
     * @param Video $video
     * @return RedirectResponse
     */
    public function delete(FileUploader $fileUploader, Video $video): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader->deleteFile($video->getImageFile());
        $em->remove($video);
        $em->flush();
        return $this->redirectToRoute('admin_video');
    }
}