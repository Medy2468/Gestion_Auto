<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementielController extends AbstractController
{
    #[Route('/evenementiel', name: 'evenementiel')]
    public function index(): Response
    {
        return $this->render('evenementiel/list.html.twig');
    }
}
