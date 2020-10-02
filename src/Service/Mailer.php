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

    public function sendMail($subject, $email, $username, $token, $template)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom("registration@dev-crown.com")
            ->setTo($email)
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/'.$template.'.html.twig',
                    [
                        'username' => $username,
                        "token" => $token
                    ]
                ),
                'text/html'
            );

        return $this->mailer->send($message);
    }

    public function sendMailResponse($subject, $email, $username, $subjectForum, $content, $id, $slug)
    {
        $message = (new \Swift_Message($subject))
            ->setFrom("forum@dev-crown.com")
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'emails/response.html.twig',
                    [
                        'username' => $username,
                        "subjectForum" => $subjectForum,
                        "content" => $content,
                        "id" => $id,
                        "slug" => $slug
                    ]
                ),
                'text/html'
            );

        return $this->mailer->send($message);
    }
}