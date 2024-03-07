<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseBController extends AbstractController
{
    #[Route('/baseB', name: 'app_base_b')]
    public function index(): Response
    {
        return $this->render('baseB.html.twig', [
            'controller_name' => 'BaseBController',
        ]);
    }
}
