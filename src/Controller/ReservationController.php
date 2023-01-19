<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
 
class ReservationController extends AbstractController
{
    #[Route('/Reservation/liste', name: 'reservation_liste')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $res = new Reservation();
        $form = $this->createForm(ReservationType::class, $res
        , array('action' => $this->generateUrl('reservation_add')));
        $data['form'] = $form->createView();

        $data['reservation'] = $entityManager->getRepository(Reservation::class)->findAll();
        return $this->render('reservation/liste.html.twig',$data);
        
    }

    #[Route('/reservation/Show', name: 'reservation_show')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $res = new Reservation();
        $form = $this->createForm(ReservationType::class, $res
        , array('action' => $this->generateUrl('reservation_show')));
        $data['form'] = $form->createView();

        $data['reservation'] = $entityManager->getRepository(Reservation::class)->findAll();
        return $this->render('reservation/add.html.twig',$data);
    }

    #[Route('/Reservation/get{id}', name: 'reservation_get')]
    public function id()
    {
        return $this->render('reservation/liste.html.twig');
    }

    #[Route('/Reservation/delete/{id}', name: 'reservation_delete')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        //$entityManager = $this->getDoctrine()->getManager();
        $entityManager = $doctrine->getManager();

        $reservation = $entityManager->getRepository(Reservation::class)->find($id);
        if ($reservation != NULL) 
        {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }
        return $this->redirectToRoute('reservation_liste');
    }

    #[Route('/Reservation/add', name: 'reservation_add')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $res = new Reservation();
        $form = $this->createForm(ReservationType::class,$res);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $res = $form->getData();
           // $res->setUser($this->getUser());
            $entityManager = $doctrine->getManager();
            $entityManager->persist($res);
            $entityManager->flush();
        }
        
        return $this->redirectToRoute('reservation_liste');
    }

    #[Route('/Reservation/edit/{id}', name: 'reservation_edit')]
    public function edit(ManagerRegistry $doctrine, $id): Response
    {
        
        $entityManager = $doctrine->getManager();
        $res = $entityManager->getRepository(Reservation::class)->find($id);

        $form = $this->createForm(ReservationType::class, $res, array('action' => $this->generateUrl('reservation_update', ['id' => $id])));
        $data['form'] = $form->createView();

        $data['reservation'] = $entityManager->getRepository(Reservation::class)->findAll();
        return $this->render('reservation/liste.html.twig', $data);
    } 

    #[Route('/Reservatino/update/{id}', name: 'reservation_update')]
    public function update(ManagerRegistry $doctrine, Request $request, $id): Response
    {
        //instancier de reservation
        $res = new Reservation();
        $form = $this->createForm(ReservationType::class, $res);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) 
        {
            $res = $form->getData();
            // recuperer l'id du User 
            $res->setUser($this->getUser());
            $res->setId($id);
            // Récupération de la base de données
            $entityManager = $doctrine->getManager();
            $reservation = $entityManager->getRepository(Reservation::class)->find($id);
            $reservation->setDateDebut($res->getDateDebut());
            $reservation->setDateFin($res->getDateFin());
            $reservation->setVoitures($res->getVoitures());
            $reservation->setUsers($res->getUsers());
            $entityManager->flush();
        }
        return $this->redirectToRoute('reservation_liste');
    }
}
