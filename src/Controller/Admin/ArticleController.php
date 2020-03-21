<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/back-office/dev-crown/article")
 * Class ArticleController
 * @package App\Controller\Admin
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="admin_article")
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render("blog/index.html.twig", [
            "articles" => $articleRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/show", name="admin_article_show")
     * @param Article $article
     * @return Response
     */
    public function show(Article $article): Response
    {
        return $this->render("blog/show.html.twig", [
            "article" => $article
        ]);
    }

    /**
     * @Route("/new", name="admin_article_new")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $imageFile = $form->get('imageFile')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile, null, "articles_directory");
                $article->setImageFile($imageFileName);
            }
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute("admin_article");
        }
        return $this->render("blog/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_article_edit")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param Article $article
     * @return Response
     */
    public function edit(Request $request, FileUploader $fileUploader, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $imageFile = $form->get('imageFile')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile, $article->getImageFile(), 'articles_directory', 1);
                $article->setImageFile($imageFileName);
            }
            $em->flush();

            return $this->redirectToRoute("admin_article");
        }
        return $this->render("blog/edit.html.twig", [
            "form" => $form->createView(),
            "article" => $article
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_article_delete")
     * @param FileUploader $fileUploader
     * @param Article $article
     * @return RedirectResponse
     */
    public function delete(FileUploader $fileUploader, Article $article): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader->deleteFile($article->getImageFile(), "articles_directory");
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute("admin_article");
    }
}