<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TabController extends AbstractController
{
    #[Route('/tab/{number<\d+>?5}', name: 'tableau')]
    public function index($number): Response
    {
        $notes = [];
        for ($i = 0 ; $i < $number ; $i++) {
            $notes[] = rand(0,20);
        }
        return $this->render('tab/index.html.twig', 
    [
        'notes' => $notes
    ]);
    }
}
