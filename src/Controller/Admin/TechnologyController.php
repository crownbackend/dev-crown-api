<?php

namespace App\Controller\Admin;

use App\Entity\Technology;
use App\Form\TechnologyType;
use App\Repository\TechnologyRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/back-office/dev-crown/technology")
 * Class TechnologyController
 * @package App\Controller\Admin
 */
class TechnologyController extends AbstractController
{
    /**
     * @Route("/", name="admin_technology")
     * @param TechnologyRepository $technologyRepository
     * @return Response
     */
    public function index(TechnologyRepository $technologyRepository): Response
    {
        return $this->render('technology/index.html.twig', [
            "technologies" => $technologyRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/show", name="admin_technology_show")
     * @param Technology $technology
     * @return Response
     */
    public function show(Technology $technology): Response
    {
        return $this->render("technology/show.html.twig", [
            "technology" => $technology
        ]);
    }

    /**
     * @Route("/new", name="admin_technology_new")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return Response
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $technology = new Technology();
        $form = $this->createForm(TechnologyType::class, $technology);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $imageFile = $form->get('imageFile')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile, null, "technology_directory");
                $technology->setImageFile($imageFileName);
            }
            $em->persist($technology);
            $em->flush();
            return  $this->redirectToRoute("admin_technology");
        }

        return $this->render('technology/new.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_technology_edit")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @param Technology $technology
     * @return Response
     */
    public function edit(Request $request, FileUploader $fileUploader, Technology $technology): Response
    {
        $form = $this->createForm(TechnologyType::class, $technology);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $imageFile = $form->get('imageFile')->getData();
            if($imageFile) {
                $imageFileName = $fileUploader->upload($imageFile, $technology->getImageFile(), 'technology_directory', 1);
                $technology->setImageFile($imageFileName);
            }
            $em->flush();
            return  $this->redirectToRoute('admin_technology');
        }

        return $this->render("technology/edit.html.twig", [
            "form" => $form->createView(),
            "technology" => $technology
        ]);
    }

    /**
     * @Route("{id}/delete", name="admin_technology_delete")
     * @param FileUploader $fileUploader
     * @param Technology $technology
     * @return RedirectResponse
     */
    public function delete(FileUploader $fileUploader, Technology $technology): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $fileUploader->deleteFile($technology->getImageFile(), "technology_directory");
        $em->remove($technology);
        $em->flush();
        return $this->redirectToRoute('admin_technology');
    }
}