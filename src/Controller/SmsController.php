<?php

namespace App\Controller;
use App\Entity\User;
use App\Entity\Cours;

use App\Service\SmsGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SmsController extends AbstractController
{
    #[Route('/sms', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('sms/index.html.twig', ['smsSent' => false]);
    }
    #[Route('/sendSms', name: 'send_sms', methods: ['GET', 'POST'])]
    public function sendSms(Request $request, SmsGenerator $smsGenerator): Response
    {
        $number = $request->request->get('number');
        $name = $request->request->get('name');
        $text = $request->request->get('text');
        $number_test = $_ENV['twilio_to_number'];
    
        // Add your logic to dynamically retrieve the Cours entity
        $user = $this->getUser(); // Assuming you have a user associated with the Cours
        $coursCollection = $user->getCours(); // Adjust this based on your entity associations
    
        // Assuming you want to get the first Cours from the collection
        $cours = $coursCollection->first();
    
        // Check if $name is not null before passing it to sendSms
        if ($name !== null && $cours !== null) {
            $smsGenerator->sendSms($number_test, $name, $text, $cours);
        } else {
            // Handle the case where $name is null or $cours is not found
            // Perhaps set a default value, show an error, or redirect with a message
            return $this->redirectToRoute('app_home', ['error' => 'Invalid parameters']);
        }
    
        return $this->render('sms/index.html.twig', ['smsSent' => true]);
    }
}    