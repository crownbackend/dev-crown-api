<?php

namespace App\Controller\Admin;

use App\Entity\Topic;
use App\Form\TopicType;
use App\Repository\TopicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/back-office/dev-crown/topics")
 * Class TopicController
 * @package App\Controller\Admin
 */
class TopicController extends AbstractController
{
    /**
     * @Route("/", name="admin_topic")
     * @param TopicRepository $topicRepository
     * @return Response
     */
    public function index(TopicRepository $topicRepository): Response
    {
        return $this->render("topic/index.html.twig", [
            "topics" => $topicRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}/show", name="admin_topic_show")
     * @param Topic $topic
     * @return Response
     */
    public function show(Topic $topic): Response
    {
        return $this->render("topic/show.html.twig", [
            "topic" => $topic
        ]);
    }

    /**
     * @Route("/new", name="admin_topic_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {
        $topic = new Topic();
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($topic);
            $em->flush();

            return $this->redirectToRoute("admin_topic");
        }
        return $this->render("topic/new.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_topic_edit")
     * @param Request $request
     * @param Topic $topic
     * @return Response
     */
    public function edit(Request $request, Topic $topic): Response
    {
        $form = $this->createForm(TopicType::class, $topic);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute("admin_topic");
        }
        return $this->render("topic/edit.html.twig", [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/delete", name="admin_topic_delete")
     * @param Topic $topic
     * @return RedirectResponse
     */
    public function delete(Topic $topic): RedirectResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($topic);
        $em->flush();
        return $this->redirectToRoute("admin_topic");
    }
}