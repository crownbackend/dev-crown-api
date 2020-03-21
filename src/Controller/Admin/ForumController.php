<?php

namespace App\Controller\Admin;

use App\Entity\Forum;
use App\Form\ForumType;
use App\Repository\ForumRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/back-office/dev-crown/forum")
 * Class ForumController
 * @package App\Controller\Admin
 */
class ForumController extends AbstractController
{
    /**
     * @Route("/", name="admin_forum")
     * @param ForumRepository $forumRepository
     * @return Response
     */
    public function index(ForumRepository $forumRepository): Response
    {
        return $this->render("forum/index.html.twig", [
            "forums" => $forumRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/show", name="admin_forum_show")
     * @param Forum $forum
     * @return Response
     */
    public function show(Forum $forum): Response
    {
        return $this->render("forum/show.html.twig", [
            "forum" => $forum
        ]);
    }

    /**
     * @Route("/new", name="admin_forum_new")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $forum = new Forum();
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $imageFile = $form->get('imageFile')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile, null, "forum_directory");
                $forum->setImageFile($imageFileName);
            }
            $em->persist($forum);
            $em->flush();

            return $this->redirectToRoute("admin_forum");
        }
        return $this->render("forum/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_forum_edit")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param Forum $forum
     * @return Response
     */
    public function edit(Request $request, FileUploader $fileUploader, Forum $forum): Response
    {
        $form = $this->createForm(ForumType::class, $forum);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $imageFile = $form->get('imageFile')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile, $forum->getImageFile(), 'forum_directory', 1);
                $forum->setImageFile($imageFileName);
            }
            $em->flush();

            return $this->redirectToRoute("admin_forum");
        }
        return $this->render("forum/edit.html.twig", [
            "form" => $form->createView(),
            "forum" => $forum
        ]);
    }

    /**
     * @Route("{id}/delete", name="admin_forum_delete")
     * @param FileUploader $fileUploader
     * @param Forum $forum
     * @return RedirectResponse
     */
    public function delete(FileUploader $fileUploader, Forum $forum): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader->deleteFile($forum->getImageFile(), "forum_directory");
        $em->remove($forum);
        $em->flush();
        return $this->redirectToRoute("admin_forum");
    }
}