<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class Mailer extends AbstractController
{


    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendMail($subject, $email, $username, $token, $template)
    {
        $email = (new TemplatedEmail())
            ->from('registration@dev-crown.com')
            ->to(new Address($email))
            ->subject($subject)

            // path of the Twig template to render
            ->htmlTemplate('emails/'.$template.'.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'username' => $username,
                'token' => $token,
            ]);

        $this->mailer->send($email);
    }

    public function sendMailResponse($subject, $email, $username, $subjectForum, $content, $id, $slug)
    {

        $email = (new TemplatedEmail())
            ->from('forum@dev-crown.com')
            ->to(new Address($email))
            ->subject($subject)

            // path of the Twig template to render
            ->htmlTemplate('emails/response.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'username' => $username,
                "subjectForum" => $subjectForum,
                "content" => $content,
                "id" => $id,
                "slug" => $slug
            ]);

        $this->mailer->send($email);
    }

    /**
     * @param $email
     * @param $name
     * @param $content
     * @return JsonResponse|void
     * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
     */
    public function contact($email, $name, $content)
    {
        $email = (new Email())
            ->from($email)
            ->to($this->getParameter("email_contact"))
            ->subject('Message de : '. $name)
            ->text($content);

        $this->mailer->send($email);
    }
}