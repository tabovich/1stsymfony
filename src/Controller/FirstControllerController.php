<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstControllerController extends AbstractController
{
    #[Route('/first', name: 'app_first_controller')]
    public function index(): Response
    {
       
       return $this->render('first_controller/index.html.twig', [
        'controller_name' => 'FirstControllerController',
       ]);
    }
}
