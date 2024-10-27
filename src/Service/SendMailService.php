<?php

namespace App\Service;

use App\Exception\SnowTrickException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class SendMailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(
        string $from,
        string $to,
        string $subject,
        string $template,
        array $context
    ): void {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("Emails/$template.html.twig")
            ->context($context);

        try {
            $this->mailer->send($email);
        } catch (\Throwable $th) {
            throw new SnowTrickException('Une erreur est survenue lors de l\'envoi de mail');
        }
    }
}
