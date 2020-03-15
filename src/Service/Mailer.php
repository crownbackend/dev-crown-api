<?php

namespace App\Service;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Mailer extends AbstractController
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail($subject, $email, $username, $token)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom("registration@dev-crown.com")
            ->setTo($email)
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',
                    [
                        'username' => $username,
                        "token" => $token
                    ]
                ),
                'text/html'
            );

        return $this->mailer->send($message);
    }

    public function sendToken($subject, $email, $username, $token)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom("registration@dev-crown.com")
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'emails/forgoutPassword.html.twig',
                    [
                        'username' => $username,
                        "token" => $token
                    ]
                ),
                'text/html'
            );

        return $this->mailer->send($message);
    }
}