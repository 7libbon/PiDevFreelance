<?php
// src/Service/MessageGenerator.php
namespace App\Service;

use App\Entity\Cours;
use Twilio\Rest\Client;

class SmsGenerator
{
    public function SendSms(string $number, string $name, string $text, Cours $cours)
    {
        $accountSid = $_ENV['twilio_account_sid'];
        $authToken = $_ENV['twilio_auth_token'];
        $fromNumber = $_ENV['twilio_from_number'];

        $toNumber = $number;
        $message = 'Dear customer, your order entiteled ' . $cours->getTitre() . ' has been confirmed successfully. Total Price: $' . $cours->getPrix();

        $client = new Client($accountSid, $authToken);

        $client->messages->create(
            $toNumber,
            [
                'from' => $fromNumber,
                'body' => $message,
            ]
        );
    }
}
