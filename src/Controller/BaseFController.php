<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseFController extends AbstractController
{
    #[Route('/baseF', name: 'app_base_f')]
    public function index(): Response
    {
        return $this->render('baseF.html.twig', [
            'controller_name' => 'BaseFController',
        ]);
    }
}
