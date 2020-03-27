<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @return Response
     */
    public function home()
    {
        return new RedirectResponse("https://dev-crown.com/");
    }

    /**
     * @Route("/031216")
     */
    public function backOffice()
    {
        return $this->redirectToRoute("admin_home");
    }
}