<?php

namespace App\Controller;



use App\Entity\Roles;
use App\Form\RoleType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RoleController extends AbstractController
{
    #[Route('/role', name: 'role_liste')]
    public function index(ManagerRegistry $doctrine): Response // Manager nous permet de communiquer avce la base de données
    {
        $entityManager = $doctrine->getManager();
        $r = new Roles();
        $form = $this->createForm(RoleType::class, $r
        , array('action' => $this->generateUrl('role_add')));
        $data['form'] = $form->createView();
        $data['roles'] = $entityManager->getRepository(Roles::class)->findAll(); // Nous permet de faire la recherche d'une categorie dans la  base de données, une fois trouvé il affiche tout dans la base de données        return $this->render('categorie/index.html.twig', [
        return $this->render('role/liste.html.twig',$data);
    }

    #[Route('/role/Show', name: 'role_show')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $r = new Roles();
        $form = $this->createForm(RoleType::class, $r
        , array('action' => $this->generateUrl('role_show')));
        $data['form'] = $form->createView();

        $data['roles'] = $entityManager->getRepository(Roles::class)->findAll();
        return $this->render('role/add.html.twig',$data);
    }

    #[Route('/Role/get{id}', name: 'role_get')]
    public function id()
    {
        return $this->render('role/liste.html.twig');
    }


    #[Route('/Role/add', name: 'role_add')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $r = new Roles(); 
        $form = $this->createForm(RoleType::class,$r);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $r = $form->getData();
            //$r->setUser($this->getUser());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($r);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('role_liste');
    }

    #[Route('/Role/delete/{id}', name: 'role_delete')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        //$entityManager = $this->getDoctrine()->getManager();
        $entityManager = $doctrine->getManager();

        $role = $entityManager->getRepository(Roles::class)->find($id);
        if ($role != NULL) 
        {
            $entityManager->remove($role);
            $entityManager->flush();
        }
        return $this->redirectToRoute('role_liste');
    }

    #[Route('/Role/edit/{id}', name: 'role_edit')]
    public function edit(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $r = $entityManager->getRepository(Roles::class)->find($id);

        $form = $this->createForm(RoleType::class, $r, array('action' => $this->generateUrl('role_update', ['id' => $id])));
        $data['form'] = $form->createView();

        $data['roles'] = $entityManager->getRepository(Roles::class)->findAll();
        return $this->render('role/liste.html.twig', $data);
    } 

    #[Route('/Role/update/{id}', name: 'role_update')]
    public function update(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        //instancier de role
        $r = new Roles();
        $form = $this->createForm(RoleType::class, $r);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            
            $r = $form->getData();
            // recuperer l'id du User 
            //$r->setUsers($this->getUsers());
            $r->setId($id);
            // Récupération de la base de données
            $entityManager = $doctrine->getManager();
            $role = $entityManager->getRepository(Roles::class)->find($id);
            $role->setNomRole($r->getNomRole());
            $entityManager->flush();
        }
        return $this->redirectToRoute('role_liste');
    }
}
