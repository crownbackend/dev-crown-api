<?php

namespace App\Controller\Admin;

use App\Entity\Playliste;
use App\Form\PlaylistType;
use App\Repository\PlaylisteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/back-office/dev-crown/playlist")
 * Class PlaylistController
 * @package App\Controller\Admin
 */
class PlaylistController extends AbstractController
{
    /**
     * @Route("/", name="admin_playlist")
     * @param PlaylisteRepository $playlisteRepository
     * @return Response
     */
    public function index(PlaylisteRepository $playlisteRepository): Response
    {
        return $this->render("playlist/index.html.twig", [
            "playlistes" => $playlisteRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/show", name="admin_playlist_show")
     * @param Playliste $playliste
     * @return Response
     */
    public function show(Playliste $playliste): Response
    {
        return $this->render("playlist/show.html.twig", [
            "playlist" => $playliste
        ]);
    }

    /**
     * @Route("/new", name="admin_playlist_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $playlist = new Playliste();
        $form = $this->createForm(PlaylistType::class, $playlist);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($playlist);
            $em->flush();

            return $this->redirectToRoute("admin_playlist");
        }
        return $this->render("playlist/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_playlist_edit")
     * @param Request $request
     * @param Playliste $playliste
     * @return Response
     */
    public function edit(Request $request, Playliste $playliste): Response
    {
        $form = $this->createForm(PlaylistType::class, $playliste);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("admin_playlist");
        }
        return $this->render("playlist/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_playlist_delete")
     * @param Playliste $playliste
     * @return RedirectResponse
     */
    public function delete(Playliste $playliste): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($playliste);
        $em->flush();

        return $this->redirectToRoute("admin_playlist");
    }
}