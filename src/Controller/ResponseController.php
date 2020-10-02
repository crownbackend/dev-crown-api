<?php

namespace App\Controller;

use App\Entity\Response;
use App\Repository\ResponseRepository;
use App\Repository\TopicRepository;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api")
 * Class ResponseController
 * @package App\Controller
 */
class ResponseController extends AbstractController
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
     * @var JWTEncoderInterface
     */
    private $JWTEncoder;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var ResponseRepository
     */
    private $responseRepository;

    public function __construct(TopicRepository $topicRepository, UserRepository $userRepository,
                                JWTEncoderInterface $JWTEncoder, ValidatorInterface $validator,
                                ResponseRepository $responseRepository)
    {
        $this->topicRepository = $topicRepository;
        $this->userRepository = $userRepository;
        $this->JWTEncoder = $JWTEncoder;
        $this->validator = $validator;
        $this->responseRepository = $responseRepository;
    }

    /**
     * @Route("/responses", name="add_responses", methods={"POST"})
     * @param Request $request
     * @param Mailer $mailer
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function addResponse(Request $request, Mailer $mailer): JsonResponse
    {
        if($request->headers->get('authorization')) {
            $tokenValid = $this->JWTEncoder->decode($request->headers->get('authorization'));
            if ($tokenValid) {
                $em = $this->getDoctrine()->getManager();
                $user = $this->userRepository->findOneBy(["id" => $request->request->get('userId')]);
                $topic = $this->topicRepository->findOneBy(["id" => $request->request->get('topicId')]);
                $response = new Response();
                $response->setUser($user);
                $response->setTopic($topic);
                $response->setContent($request->request->get("description"));
                $errors = $this->validator->validate($response);
                if (count($errors) > 0) {
                    $errorsString = (string) $errors;
                    return $this->json(["error" => $errorsString]);
                }
                $em->persist($response);
                $em->flush();
                $mailer->sendMailResponse($topic->getTitle(), $topic->getUser()->getEmail(),
                    $topic->getUser()->getUsername(), $topic->getTitle(), $response->getContent(), $topic->getId(),
                    $topic->getSlug());
                $responses = $this->responseRepository->findResponseByTopic($topic);
                return $this->json(["responses" =>$responses], 200, [], ["groups" => "addResponse"]);
            }
        } else {
            return $this->json(["error" => 0], 400);
        }
    }
}