<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(): Response
    {
        return $this->render('login/index.html.twig');
    }

    #[Route('/logins', name: 'logins')]
    public function Login(): Response
    {
        return $this->render('login/index.html.twig');
    }

    #[Route('/logon', name: 'logon')]
    public function Logon(): Response
    {
        return $this->redirectToRoute('accueil');
    }
}
