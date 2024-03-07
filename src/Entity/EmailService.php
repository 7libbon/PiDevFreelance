<?php
namespace App\Service;

use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;

class EmailService
{
    private Mailer $mailer;

    public function __construct(string $smtpDsn)
    {
        $transport = Transport::fromDsn($smtpDsn);
        $this->mailer = new Mailer($transport);
    }

    public function sendEmail(string $to, string $subject, string $body): void
    {
        $email = (new Email())
            ->from('moncefhallab15@gmail.com')
            ->to($to)
            ->subject($subject)
            ->html($body);

        try {
            $this->mailer->send($email);
            // Log or handle success
        } catch (TransportExceptionInterface $e) {
            // Log or handle error
            // throw $e; // Uncomment this line if you want to propagate the exception
        }
    }
}
