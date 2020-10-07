<?php

namespace App\Controller;

use App\Repository\TopicRepository;
use App\Repository\UserRepository;
use App\Repository\VideoRepository;
use App\Service\FileUploader;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api")
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @var JWTEncoderInterface
     */
    private $JWTEncoder;
    /**
     * @var VideoRepository
     */
    private $videoRepository;
    /**
     * @var TopicRepository
     */
    private $topicRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(JWTEncoderInterface $JWTEncoder, VideoRepository $videoRepository,
                                TopicRepository $topicRepository, UserRepository $userRepository)
    {
        $this->JWTEncoder = $JWTEncoder;
        $this->videoRepository = $videoRepository;
        $this->topicRepository = $topicRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/profile/{username}", name="user_profile", methods={"GET"})
     * @param string $username
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function profile(string $username, Request $request,
                            JWTEncoderInterface $JWTEncoder, UserRepository $userRepository): JsonResponse
    {
        $token = $request->headers->get('authorization');
        $tokenValid = $JWTEncoder->decode($token);
        if($tokenValid['username']) {
            return $this->json($this->userRepository->findOneBy(["username" => $username]), 200, [], ["groups" => "user"]);
        } else {
            return $this->json(["token not valid" => 0], 500);
        }
    }

    /**
     * @Route("/profile/edit/", name="user_edit", methods={"PUT"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param FileUploader $fileUploader
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function edit(Request $request, UserPasswordEncoderInterface $passwordEncoder,
                         FileUploader $fileUploader, ValidatorInterface $validator): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $token = $request->headers->get('authorization');
        $tokenValid = $this->JWTEncoder->decode($token);
        if($tokenValid['username']) {
            $user = $this->userRepository->findOneBy(["username" => $tokenValid['username']]);
            $user->setUsername($request->request->get("username"));
            $user->setEmail($request->request->get("email"));
            $errors = $validator->validate($user, null, ['user']);
            // check password is good !
            if($request->request->get('password') != "null") {
                $res = preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,50}$/',
                    $request->request->get('password'));
                if($res == 1) {
                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $request->request->get('password')
                        )
                    );
                } else {
                    return $this->json('Le mot de passe est incorrecte');
                }
            }
            if($request->files->get("avatar")) {
                $avatarFileName = $fileUploader->upload($request->files->get("avatar"), $user->getAvatar(), "avatar_directory", 1);
                $user->setAvatar($avatarFileName);
            }
            if (count($errors) > 0) {
                // return error
                return $this->json($errors);
            } else {
                $em->persist($user);
                $em->flush();
                return $this->json(["edit" => 1], 200);
            }
        } else {
            return $this->json(["token not valid" => 0], 500);
        }
    }

    /**
     * @Route("/profile/videos/{id}", name="user_videos", methods={"GET"})
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function videos(Request $request, $id): JsonResponse
    {
        if($request->headers->get('authorization')) {
            $tokenValid = $this->JWTEncoder->decode($request->headers->get('authorization'));
            if ($tokenValid) {
                $videos = $this->videoRepository->findVideoByUser($id);
                foreach ($videos as $video) {
                    $video->favored = 1;
                }
                return $this->json(["videos" => $videos], 200, [], ["groups" => "profileVideos"]);
            }
        } else {
            return $this->json(["error" => 0], 400);
        }
    }

    /**
     * @Route("/profile/topics/{id}", name="user_topics", methods={"GET"})
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function topics(Request $request, $id): JsonResponse
    {
        if($request->headers->get('authorization')) {
            $tokenValid = $this->JWTEncoder->decode($request->headers->get('authorization'));
            if ($tokenValid) {
                $user = $this->userRepository->findOneBy(["id" => $id]);
                $topics = $this->topicRepository->findBy(["user" => $user]);
                // return topics where user add response on topic
                $responses = $this->topicRepository->findTopicsResponsesByUser($user);
                return $this->json(["topics" => $topics, 'topicsResponses' => $responses], 200, [], ["groups" => "profileTopics"]);
            }
        } else {
            return $this->json(["error" => 0], 400);
        }
    }

    /**
     * @Route("/profile/delete/account/{id}", name="delete_account", methods={"DELETE"})
     * @param Request $request
     * @param $id
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function deleteAccount(Request $request, $id): JsonResponse
    {
        if($request->headers->get('authorization')) {
            $tokenValid = $this->JWTEncoder->decode($request->headers->get('authorization'));
            if ($tokenValid) {
                $em = $this->getDoctrine()->getManager();
                $user = $this->userRepository->findOneBy(["id" => $id]);
                $em->remove($user);
                $em->flush();
                return $this->json(["success" => 1], 200);
            }
        } else {
            return $this->json(["error" => 0], 400);
        }
    }
}