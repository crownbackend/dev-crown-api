<?php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/back-office/dev-crown")
 * Class HomeController
 * @package App\Controller\Admin
 */
class HomeController extends AbstractController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @Route("/", name="admin_home")
     * @return Response
     */
    public function home(): Response
    {
        $users = $this->userRepository->countUsers('ROLE_USER');
        $usersEnabled = $this->userRepository->countUsers('ROLE_USER', 1);

        return $this->render("index.html.twig", [
            "users" => $users,
            "usersEnabled" => $usersEnabled
        ]);
    }


}