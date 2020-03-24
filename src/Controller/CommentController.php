<?php

namespace App\Controller;

use App\Entity\CommentVideo;
use App\Repository\CommentVideoRepository;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 * Class CommentController
 * @package App\Controller
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/comments", name="comment_new", methods={"POST"})
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param UserRepository $userRepository
     * @param VideoRepository $videoRepository
     * @param CommentVideoRepository $commentVideoRepository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function new(Request $request, JWTEncoderInterface $JWTEncoder,
                        UserRepository $userRepository, VideoRepository $videoRepository,
                        CommentVideoRepository $commentVideoRepository): JsonResponse
    {

        if(strlen($request->request->get("content")) < 10) {
            return $this->json(["comment" => 0]);
        }
        $tokenValid = $JWTEncoder->decode($request->request->get("token"));
        if($tokenValid['username']) {
            $em = $this->getDoctrine()->getManager();
            $user = $userRepository->findOneBy(['username' => $tokenValid['username']]);
            $video = $videoRepository->findOneBy(['id' => (int)$request->request->get("video")]);
            $comment = new CommentVideo();
            $comment->setUser($user);
            $comment->setVideo($video);
            $comment->setContent($request->request->get("content"));
            $comment->setCreatedAt(new \DateTime());
            $em->persist($comment);
            $em->flush();
            return $this->json(["comments" => $commentVideoRepository->findByCommentsByVideo($video)], 200, [], ["groups" => "video"]);
        } else {
            return $this->json($tokenValid);
        }
    }

    /**
     * @Route("/comments", name="edit_comment", methods={"PUT"})
     * @param Request $request
     * @return JsonResponse
     */
    public function edit(Request $request): JsonResponse
    {
        return $this->json($request->request);
    }

    /**
     * @Route("/comments/{id}", name="comments", methods={"GET"})
     * @param $id
     * @param CommentVideoRepository $commentVideoRepository
     * @param VideoRepository $videoRepository
     * @return JsonResponse
     */
    public function comments($id, CommentVideoRepository $commentVideoRepository, VideoRepository $videoRepository): JsonResponse
    {
        $video = $videoRepository->findOneBy(["id" => (int)$id]);
        return  $this->json(["comments" => $commentVideoRepository->findByCommentsByVideo($video)], 200, [], ["groups" => "video"]);
    }
}