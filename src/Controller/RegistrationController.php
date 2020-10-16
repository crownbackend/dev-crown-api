<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api")
 * Class RegistrationController
 * @package App\Controller
 */
class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="register", methods={"POST"})
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param ValidatorInterface $validator
     * @param Mailer $mailer
     * @return JsonResponse
     * @throws \Exception
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder,
                             ValidatorInterface $validator, Mailer $mailer): JsonResponse
    {
        // call doctrine
        $em = $this->getDoctrine()->getManager();
        // set data in user object
        $user = new User();
        $user->setUsername($request->request->get('username'));
        $user->setEmail($request->request->get('email'));
        $user->setConfirmationToken($this->generateToken());
        $user->setConfirmationTokenCreatedAt(new \DateTime());
        // check password is good !
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
        // check data is valid
        $errors = $validator->validate($user, null, ['particular']);
        if (count($errors) > 0) {
            // return error
            $errorsString = (string) $errors;
            return $this->json($errorsString);
        } else {
            $em->persist($user);
            $em->flush();

            if($user->getConfirmationToken()) {
                $mailer->sendMail("Mail de confirmation", $user->getEmail(),
                    $user->getUsername(), $user->getConfirmationToken(), 'registration');
            }

            return  $this->json(['created' => 1], 201, [], ["groups" => "user"]);
        }
    }

    /**
     * @Route("/register/confirm/account/{token}", name="confirm_account", methods={"GET"})
     * @param string $token
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function confirmAccount(string $token, UserRepository $userRepository): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $user = $userRepository->findOneBy(['confirmationToken' => $token]);
        if($user) {
            $user->setConfirmationTokenCreatedAt(null);
            $user->setConfirmationToken(null);
            $user->setEnabled(1);
            $em->persist($user);
            $em->flush();
            return $this->json(['confirmation' => 1], 200);
        } else {
            return $this->json(['confirmation' => 0]);
        }
    }

    /**
     * @Route("/forgot/password", name="send_new_password", methods={"POST"})
     * @param Request $request
     * @param Mailer $mailer
     * @param UserRepository $userRepository
     * @return JsonResponse
     * @throws \Exception
     */
    public function sendNewPassword(Request $request, Mailer $mailer, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['email' => $request->request->get('email')]);
        if($user) {
            $em = $this->getDoctrine()->getManager();
            $user->setTokenPassword($this->generateToken());
            $user->setTokenPasswordCreatedAt(new \DateTime());
            $em->persist($user);
            $em->flush();
            $mailer->sendMail("Mot de passe oublié", $user->getEmail(),
                $user->getUsername(), $user->getTokenPassword(), 'forgoutPassword');
            return $this->json(['success' => 1]);
        } else {
            return $this->json(['error' => 1]);
        }
    }

    /**
     * @Route("/forgot/password/{token}", name="confirm_password", methods={"GET", "POST"})
     * @param UserRepository $userRepository
     * @param Request $request
     * @param string $token
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return JsonResponse
     */
    public function confirmPassword(UserRepository $userRepository, Request $request,
                                    string $token, UserPasswordEncoderInterface $passwordEncoder): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $user = $userRepository->findOneBy(['tokenPassword' => $token]);
        if($user) {
            $res = preg_match('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,50}$/', $request->request->get('password'));
            if($res == 1) {
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $request->request->get('password')
                    )
                );
            } else {
                return $this->json(['errorPassword' => 0], 400);
            }
            $user->setTokenPassword(null);
            $user->setTokenPasswordCreatedAt(null);
            $em->persist($user);
            $em->flush();
            return $this->json(['success' => 1]);
        } else {
            return $this->json(['error' => 0]);
        }
    }

    /**
     * @Route("/verify/username/{username}", name="verify_username", methods={"GET"})
     * @param string $username
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function verifyUsername(string $username, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['username' => $username]);
        if($user) {
            return $this->json(["error" => 1, "username" => $user->getUsername()], 200);
        } else {
            return $this->json(['good' => 1], 200);
        }
    }

    /**
     * @Route("/verify/email/{email}", name="verify_email", methods={"GET"})
     * @param string $email
     * @param UserRepository $userRepository
     * @return JsonResponse
     */
    public function verifyEmail(string $email, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(['email' => $email]);
        if($user) {
            return $this->json(["error" => 1, "email" => $user->getEmail()], 200);
        } else {
            return $this->json(['good' => 1], 200);
        }
    }

    /**
     * @return false|string|string[]|null
     */
    private function generateToken()
    {
        return mb_strtoupper(strval(bin2hex(openssl_random_pseudo_bytes(16))));
    }
}