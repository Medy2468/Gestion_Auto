<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Form\DemandeType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DemandeController extends AbstractController
{
    #[Route('/demande ', name: 'demande_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $d = new Demande();
        $form = $this->createForm(DemandeType::class, $d
        , array('action' => $this->generateUrl('demande_add')));
        $data['form'] = $form->createView();

        $data['demandes'] = $entityManager->getRepository(Demande::class)->findAll();
        return $this->render('demande/list.html.twig',$data);
    }

    #[Route('/demande/Show', name: 'demande_show')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $d = new Demande();
        $form = $this->createForm(DemandeType::class, $d
        , array('action' => $this->generateUrl('demande_show')));
        $data['form'] = $form->createView();

        $data['demandes'] = $entityManager->getRepository(Demande::class)->findAll();
        return $this->render('demande/add.html.twig',$data);
    }

    #[Route('/Demande/get{id}', name: 'demande_get')]
    public function id()
    {
        return $this->render('demande /list.html.twig');
    }


    #[Route('/Demande/add', name: 'demande_add')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $d = new Demande();
        $form = $this->createForm(DemandeType::class,$d);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $d = $form->getData();
            //$u->setUser($this->getUser());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($d);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('demande_liste');
    }

    #[Route('/Demande/delete/{id}', name: 'demande_delete')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        //$entityManager = $this->getDoctrine()->getManager();
        $entityManager = $doctrine->getManager();

        $demande = $entityManager->getRepository(Demande::class)->find($id);
        if ($demande != NULL) 
        {
            $entityManager->remove($demande);
            $entityManager->flush();
        }
        return $this->redirectToRoute('demande_liste');
    }

    #[Route('/Demande/edit/{id}', name: 'demande_edit')]
    public function edit(ManagerRegistry $doctrine, $id): Response
    {
        
        $entityManager = $doctrine->getManager();
        $d = $entityManager->getRepository(Demande::class)->find($id);

        $form = $this->createForm(DemandeType::class, $d, array('action' => $this->generateUrl('demande_update', ['id' => $id])));
        $data['form'] = $form->createView();

        $data['demandes'] = $entityManager->getRepository(Demande::class)->findAll();
        return $this->render('demande/list.html.twig', $data);
    } 

    #[Route('/Demandes/update/{id}', name: 'demande_update')]
    public function update(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        //instancier le user
        $d = new Demande();
        $form = $this->createForm(DemandeType::class, $d);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $d = $form->getData();
            // recuperer l'id du User 
            //$u->setUser($this->getUser());
            //$u->setId($id);
            // Récupération de la base de données
            $entityManager = $doctrine->getManager();
            $demande = $entityManager->getRepository(Demande::class)->find($id);
            $demande->setNumeroDemande($d->getNumeroDemande());
            $demande->setInfoDemande($d->getInfoDemande());
            $demande->setDateDemande($d->getDateDemande());
            $demande->setVoitures($d->getVoitures());
            $demande->setUsers($d->getUsers());
            $entityManager->flush(); 
        }
        return $this->redirectToRoute('demande_liste');
    }
}
