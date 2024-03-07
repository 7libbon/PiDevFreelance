<?php

namespace App\Controller;

use App\Form\EmailFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class MailerController extends AbstractController
{
    #[Route('/send-email', name: 'app_send_email')]
    public function index(MailerInterface $mailer, Request $request): Response
    {
        $form = $this->createForm(EmailFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new Email())
                ->from($data['from'])
                ->to($data['to'])
                ->subject($data['subject'])
                ->text($data['text']);

            $mailer->send($email);

            return $this->redirectToRoute('app_coursb_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mailer/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}