<?php

namespace App\Controller;
use App\Entity\Messages;
use App\Form\MessageType;
use App\Entity\User;

use App\Repository\MessagesRepository;

use Doctrine\Common\Collections\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
class MessagesController extends AbstractController
{
     /**
     * @Route("/messages", name="messages")
     */
    public function index(MessagesRepository $messagesRepository): Response
    {
        $user = $this->getUser();
        $sentMessages = $this->getDoctrine()->getRepository(Messages::class)->findBy(['sender' => $user]);
        $receivedMessages = $this->getDoctrine()->getRepository(Messages::class)->findBy(['recipient' => $user]);
        
        return $this->render('messages/index.html.twig', [
            'user' => $user,
            'sentMessages' => $sentMessages,
            'receivedMessages' => $receivedMessages,
        ]);
        
    }
    
    /**
     * @Route("/send", name="send")
     */

public function send (Request $request): Response
{
    $message = new Messages;
    $form = $this->createForm(MessageType::class, $message);
    
    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $message->setSender($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        $this->addFlash("message", "Message envoyé avec succès.");
        return $this->redirectToRoute("messages");
    }

    return $this->render("messages/send.html.twig", [
        "form" => $form->createView()
    ]);
}

    /**
     * @Route("/received", name="received")
     */
    public function received(): Response
    {
        $user = $this->getUser();
        $sentMessages = $this->getDoctrine()->getRepository(Messages::class)->findBy(['sender' => $user]);
        $receivedMessages = $this->getDoctrine()->getRepository(Messages::class)->findBy(['recipient' => $user]);
        
        return $this->render('messages/received.html.twig', [
            'user' => $user,
            'sentMessages' => $sentMessages,
            'receivedMessages' => $receivedMessages,
        ]);
        }
  /**
     * @Route("/sent", name="sent")
     */
    public function sent(): Response
    {
        $user = $this->getUser();
        $sentMessages = $this->getDoctrine()->getRepository(Messages::class)->findBy(['sender' => $user]);
        $receivedMessages = $this->getDoctrine()->getRepository(Messages::class)->findBy(['recipient' => $user]);
        
        return $this->render('messages/sent.html.twig', [
            'user' => $user,
            'sentMessages' => $sentMessages,
            'receivedMessages' => $receivedMessages,
        ]);    }

 /**
     * @Route("/read/{id}", name="read")
     */
    public function read(Messages $message): Response
    {
        $message->setIsRead(true);
        $em = $this->getDoctrine()->getManager();
        $em->persist($message);
        $em->flush();

        return $this->render('messages/read.html.twig', compact("message"));
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Messages $message): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($message);
        $em->flush();

        return $this->redirectToRoute("received");
    }

}