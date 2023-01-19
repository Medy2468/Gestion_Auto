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

class UserController extends AbstractController
{
    #[Route('/User/liste', name: 'user_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $u = new User();
        $form = $this->createForm(UserType::class, $u
        , array('action' => $this->generateUrl('user_add')));
        $data['form'] = $form->createView();

        $data['users'] = $entityManager->getRepository(User::class)->findAll();
        return $this->render('user/liste.html.twig',$data);
    }
 
    #[Route('/User/Show', name: 'user_show')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $u = new User();
        $form = $this->createForm(UserType::class, $u
        , array('action' => $this->generateUrl('user_show')));
        $data['form'] = $form->createView();

        $data['users'] = $entityManager->getRepository(User::class)->findAll();
        return $this->render('user/affichage.html.twig',$data);
    }

    #[Route('/User/get{id}', name: 'user_get')]
    public function id()
    {
        return $this->render('user/liste.html.twig');
    }



    #[Route('/User/add', name: 'user_add')]
    public function add(ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher , Request $request): Response
    { 
        $u = new User(); 
        $form = $this->createForm(UserType::class,$u);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Utilisateur ajouté !!');
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
        
        return $this->redirectToRoute('user_liste');
    }

    #[Route('/User/delete/{id}', name: 'user_delete')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        //$entityManager = $this->getDoctrine()->getManager();
        $entityManager = $doctrine->getManager();

        $user = $entityManager->getRepository(User::class)->find($id);
        if ($user != NULL) 
        {
            $entityManager->remove($user);
            $entityManager->flush();
        }
        return $this->redirectToRoute('user_liste');
    }

    #[Route('/User/edit/{id}', name: 'user_edit')]
    public function edit(ManagerRegistry $doctrine, $id): Response
    {
        
        $entityManager = $doctrine->getManager();
        $u = $entityManager->getRepository(User::class)->find($id);

        $form = $this->createForm(UserType::class, $u, array('action' => $this->generateUrl('user_update', ['id' => $id])));
        $data['form'] = $form->createView();

        $data['users'] = $entityManager->getRepository(User::class)->findAll();
        return $this->render('user/liste.html.twig', $data);
    } 

    #[Route('/Users/update/{id}', name: 'user_update')]
    public function update(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        //instancier le user
        $u = new User();
        $form = $this->createForm(UserType::class, $u);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $u = $form->getData();
            // recuperer l'id du User 
            //$u->setUser($this->getUser());
            //$u->setId($id);
            // Récupération de la base de données
            $entityManager = $doctrine->getManager();
            $user = $entityManager->getRepository(User::class)->find($id);
            $user->setNom($u->getNom());
            $user->setPrenom($u->getPrenom());
            $user->setEmail($u->getEmail());
            $user->setPassword($u->getPassword());
            $user->setTel($u->getTel());
            $user->setCni($u->getCni());
            $user->setAdresse ($u->getAdresse());
            $entityManager->flush(); 
        }
        return $this->redirectToRoute('user_liste');
    }
}
