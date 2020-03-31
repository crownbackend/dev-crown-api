<?php

namespace App\Controller;

use App\Entity\CommentArticle;
use App\Repository\ArticleRepository;
use App\Repository\CommentArticleRepository;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class CommentArticleController
 * @package App\Controller
 */
class CommentArticleController extends AbstractController
{
    /** @Route("/comments/article/{id}", name="comments_article", methods={"GET"})
     * @param CommentArticleRepository $commentArticleRepository
     * @param ArticleRepository $articleRepository
     * @param $id
     * @return JsonResponse
     */
    public function comments(CommentArticleRepository $commentArticleRepository,
                             ArticleRepository $articleRepository, $id): JsonResponse
    {
        $article = $articleRepository->findOneBy(['id' => $id]);
        return $this->json(["comments" => $commentArticleRepository->findByCommentArticle($article)], 200, [], ["groups" => "commentArticle"]);
    }

    /**
     * @Route("/comments/article", name="new_comment", methods={"POST"})
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param CommentArticleRepository $commentArticleRepository
     * @param UserRepository $userRepository
     * @param ArticleRepository $articleRepository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function new(Request $request, JWTEncoderInterface $JWTEncoder, CommentArticleRepository $commentArticleRepository,
                        UserRepository $userRepository, ArticleRepository $articleRepository): JsonResponse
    {
        if(strlen($request->request->get("content")) < 10) {
            return $this->json(["comment" => 0]);
        }
        $tokenValid = $JWTEncoder->decode($request->request->get("token"));
        if($tokenValid['username']) {
            $em = $this->getDoctrine()->getManager();
            $user = $userRepository->findOneBy(["username" =>$tokenValid['username']]);
            $article = $articleRepository->findOneBy(['id' => (int)$request->request->get("article")]);
            $comment = new CommentArticle();
            $comment->setArticle($article);
            $comment->setUser($user);
            $comment->setContent($request->request->get("content"));
            $comment->setCreatedAt(new \DateTime());
            $em->persist($comment);
            $em->flush();
            return $this->json(["comments" => $commentArticleRepository->findByCommentArticle($article)], 200, [], ["groups" => "commentArticle"]);
        } else {
            return $this->json($tokenValid);
        }
    }

    /**
     * @Route("/comments/article/{id}", name="edit_comment", methods={"PUT"})
     * @param Request $request
     * @param $id
     * @param JWTEncoderInterface $JWTEncoder
     * @param CommentArticleRepository $commentArticleRepository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function edit(Request $request, $id, JWTEncoderInterface $JWTEncoder,
                         CommentArticleRepository $commentArticleRepository): JsonResponse
    {
        $tokenValid = $JWTEncoder->decode($request->request->get("token"));
//        return $this->json($id); die;
        if(strlen($request->request->get("content")) < 10) {
            return $this->json(["comment" => 0]);
        }
        if($tokenValid['username']) {
            $em = $this->getDoctrine()->getManager();
            $comment = $commentArticleRepository->findOneBy(["id" => $id]);
            $comment->setContent($request->request->get('content'));
            $comment->setUpdatedAt(new \DateTime());
            $em->persist($comment);
            $em->flush();
            return $this->json(["comments" => $commentArticleRepository->findByCommentArticle($comment->getArticle()), "edit" => 1], 200, [], ["groups" => "commentArticle"]);
        } else {
            return $this->json($tokenValid);
        }
    }

    /**
     * @Route("/comments/article/{id}", name="delete_comment", methods={"DELETE"})
     * @param $id
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param CommentArticleRepository $commentArticleRepository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function delete($id, Request $request, JWTEncoderInterface $JWTEncoder,
                           CommentArticleRepository $commentArticleRepository): JsonResponse
    {
        $tokenValid = $JWTEncoder->decode($request->headers->get('authorization'));
        if($tokenValid['username']) {
            $em =$this->getDoctrine()->getManager();
            $comment = $commentArticleRepository->findOneBy(["id" => $id]);
            $em->remove($comment);
            $em->flush();
            return $this->json(["comments" => $commentArticleRepository->findByCommentArticle($comment->getArticle())], 200, [], ["groups" => "commentArticle"]);
        } else {
            return $this->json($tokenValid);
        }
    }
}