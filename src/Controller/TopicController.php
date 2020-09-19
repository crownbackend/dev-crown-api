<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Repository\ForumRepository;
use App\Repository\TopicRepository;
use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api")
 * Class TopicController
 * @package App\Controller
 */
class TopicController extends AbstractController
{
    /**
     * @var TopicRepository
     */
    private $topicRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var ForumRepository
     */
    private $forumRepository;

    public function __construct(TopicRepository $topicRepository, UserRepository $userRepository,
                                ForumRepository $forumRepository)
    {
        $this->topicRepository = $topicRepository;
        $this->userRepository = $userRepository;
        $this->forumRepository = $forumRepository;
    }

    /**
     * @Route("/topic/{id}/{slug}", name="topic", methods={"GET"})
     * @param $slug
     * @param $id
     * @return JsonResponse
     */
    public function topic($slug, $id): JsonResponse
    {
        return $this->json(["topic" => $this->topicRepository->findOneBy(["id" => $id, "slug" => $slug])],
            200, [], ["groups" => "topic"]);
    }

    /**
     * @Route("/last/topics", name="last_topics", methods={"GET"})
     * @return JsonResponse
     */
    public function topics(): JsonResponse
    {
        return $this->json(["topics" => $this->topicRepository->findByLastTopic()],
            200, [], ["groups" => "lastTopics"]);
    }

    /**
     * @Route("/topics/show/more/{date}/{id}", name="load_topics", methods={"GET"})
     * @param $date
     * @param $id
     * @return JsonResponse
     * @throws \Exception
     */
    public function topicsShowMore($date, $id): JsonResponse
    {
        $d = new \DateTime($date);
        return $this->json(["topics" => $this->topicRepository->findByLoadMoreTopics($d->format("Y-m-d H:i:s"),
            $id)], 200, [], ["groups" => "topicsMore"]);
    }

    /**
     * @Route("/topic/new", name="add_topic", methods={"POST"})
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param JWTEncoderInterface $JWTEncoder
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function addTopic(Request $request, ValidatorInterface $validator,
                             JWTEncoderInterface $JWTEncoder): JsonResponse
    {
        if($request->headers->get('authorization'))  {
            $tokenValid = $JWTEncoder->decode($request->headers->get('authorization'));
            if($tokenValid) {
                $em = $this->getDoctrine()->getManager();
                $user = $this->userRepository->findOneBy(["id" => (int)$request->request->get('userId')]);
                $forum = $this->forumRepository->findOneBy(["id" => $request->request->get("forum")]);
                $topic = new Topic();
                $topic->setTitle($request->request->get("title"));
                $topic->setDescription($request->request->get("description"));
                $topic->setUser($user);
                $topic->setForum($forum);
                $errors = $validator->validate($topic);
                if (count($errors) > 0) {
                    $errorsString = (string) $errors;
                    return $this->json($errorsString);
                }
                $em->persist($topic);
                $em->flush();
                return $this->json([
                    "success" => 1, "topicId" => $topic->getId(),
                    "slug" => $topic->getSlug()
                ]);
            }
        } else {
            return $this->json(["error" => 0]);
        }
    }
}