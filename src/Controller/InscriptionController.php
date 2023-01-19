<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class InscriptionController extends AbstractController
{
    #[Route('/Inscription/liste', name: 'inscription_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $u = new User();
        $form = $this->createForm(UserType::class, $u
        , array('action' => $this->generateUrl('inscription_add')));
        $data['form'] = $form->createView();

        $data['users'] = $entityManager->getRepository(User::class)->findAll();
        return $this->render('inscription/liste.html.twig',$data);
    }

    #[Route('/Inscription/get{id}', name: 'inscription_get')]
    public function id()
    {
        return $this->render('inscription/liste.html.twig');
    }

    #[Route('/Inscription/add', name: 'inscription_add')]
    public function add(ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher , Request $request): Response
    { 
        $u = new User();
        $form = $this->createForm(UserType::class,$u);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $u->setPassword(
                $userPasswordHasher->hashPassword(
                        $u,
                        $form->get('password')->getData()
                    )
                );

            $u = $form->getData();
            //$u->setUser($this->getUser());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($u);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('app_logout');
    }
}
