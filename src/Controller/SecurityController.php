<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\FileUploader;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api")
 * Class SecurityController
 * @package App\Controller
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login_check", name="login", methods={"POST"})
     * @param JWTTokenManagerInterface $JWTTokenManager
     * @param UserRepository $userRepository
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return JsonResponse
     * @throws \Exception
     */
    public function loginApi(JWTTokenManagerInterface $JWTTokenManager, UserRepository $userRepository,
                          Request $request, UserPasswordEncoderInterface $passwordEncoder): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        // get login and password form request content
        $data = json_decode($request->getContent(), true);
        // check user exist
        $user = $userRepository->findOneBy(['username' => $data['username']]);
        if($user == null) {
            return $this->json(["notAccount" => 0], 200);
        }
        if($user->getEnabled() == 0) {
            return  $this->json(['enable' => 0], 200);
        }
        if($user && $passwordEncoder->isPasswordValid($user, $data['password'])) {
            if(in_array("ROLE_USER",$user->getRoles())) {
                $user->setLastLogin(new \DateTime());
                $em->persist($user);
                return $this->json(['token' => $JWTTokenManager->create($user), 'user' => $user->getUsername(),
                    "userId" => $user->getId(), "email" => $user->getEmail()],
                    200);
            } else if(in_array("ROLE_ADMIN", $user->getRoles())) {
                $user->setLastLogin(new \DateTime());
                $em->persist($user);
                return $this->json(['token' => $JWTTokenManager->create($user), 'user' => $user->getUsername(),
                    "userId" => $user->getId(), "email" => $user->getEmail()],
                    200);
            }
            $em->flush();
        } else {
            return  $this->json(["errorLogin" => 0], 200);
        }
    }

    /**
     * @Route("/check/login/verify/token"), name="verify_token", methods={"GET"})
     * @param Request $request
     * @param JWTEncoderInterface $JWTEncoder
     * @return JsonResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException
     */
    public function checkToken(Request $request, JWTEncoderInterface $JWTEncoder): JsonResponse
    {
        $token = $request->headers->get('authorization');
        $tokenValid = $JWTEncoder->decode($token);
        if($tokenValid['username']) {
            return $this->json(["token_valid" => 1], Response::HTTP_OK);
        } else {
            return $this->json(["token_not_valid" => 0], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
             return $this->redirectToRoute('back-office');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('home');
    }
}