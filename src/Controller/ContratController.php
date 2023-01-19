<?php

namespace App\Controller;

use App\Entity\Contrat;
use App\Form\ContratType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContratController extends AbstractController
{
 
    #[Route('/Contrat', name: 'contrat')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $c = new Contrat();
        $form = $this->createForm(ContratType::class, $c
        , array('action' => $this->generateUrl('contrat_add')));
        $data['form'] = $form->createView();

        $data['contrats'] = $entityManager->getRepository(Contrat::class)->findAll();
        return $this->render('contrat/list.html.twig',$data);
    }

    #[Route('/contrat/Show', name: 'contrat_show')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $c = new Contrat();
        $form = $this->createForm(ContratType::class, $c
        , array('action' => $this->generateUrl('contrat_show')));
        $data['form'] = $form->createView();

        $data['contrats'] = $entityManager->getRepository(Contrat::class)->findAll();
        return $this->render('contrat/add.html.twig',$data);
    }


    #[Route('/Contrat/get{id}', name: 'contrat_get')]
    public function id()
    {
        return $this->render('contrat/list.html.twig');
    }


    #[Route('/Contrat/add', name: 'contrat_add')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $c = new Contrat();
        $form = $this->createForm(ContratType::class,$c);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $c = $form->getData();
            //$u->setUser($this->getUser());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($c);
            $entityManager->flush(); 
        }
        
        return $this->redirectToRoute('contrat');
    }

    #[Route('/Contrat/delete/{id}', name: 'contrat_delete')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        //$entityManager = $this->getDoctrine()->getManager();
        $entityManager = $doctrine->getManager();

        $contrat = $entityManager->getRepository(Contrat::class)->find($id);
        if ($contrat != NULL) 
        {
            $entityManager->remove($contrat);
            $entityManager->flush();
        }
        return $this->redirectToRoute('contrat');
    }

    #[Route('/Contrat/edit/{id}', name: 'contrat_edit')]
    public function edit(ManagerRegistry $doctrine, $id): Response
    {
        
        $entityManager = $doctrine->getManager();
        $c = $entityManager->getRepository(Contrat::class)->find($id);

        $form = $this->createForm(ContratType::class, $c, array('action' => $this->generateUrl('contrat_update', ['id' => $id])));
        $data['form'] = $form->createView();

        $data['contrats'] = $entityManager->getRepository(Contrat::class)->findAll();
        return $this->render('contrat/list.html.twig', $data);
    } 

    #[Route('/Contrats/update/{id}', name: 'contrat_update')]
    public function update(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        //instancier le user
        $c = new Contrat();
        $form = $this->createForm(ContratType::class, $c);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $c = $form->getData();
            // recuperer l'id du User 
            //$u->setUser($this->getUser());
            //$u->setId($id);
            // Récupération de la base de données
            $entityManager = $doctrine->getManager();
            $contrat = $entityManager->getRepository(Contrat::class)->find($id);
            $contrat->setNumeroContrat($c->getNumeroContrat());
            $contrat->setDateDebut($c->getDateDebut());
            $contrat->setDateFin($c->getDateFin());
            $contrat->setMontant($c->getMontant());
            $contrat->setTypeContrat($c->getTypeContrat());
            $contrat->setDateContrat($c->getDateContrat());
            $contrat->setUsers($c->getUsers());
            $contrat->setVoitures($c->getVoitures());
            $entityManager->flush();
        }
        return $this->redirectToRoute('contrat');
    }
}
