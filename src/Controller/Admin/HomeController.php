<?php

namespace App\Controller\Admin;

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
     * @Route("/", name="admin_home")
     * @return Response
     */
    public function home(): Response
    {
        return $this->render("index.html.twig");
    }
}