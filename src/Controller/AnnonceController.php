<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Annonce;
use App\Form\AnnonceType;
use App\Form\VoitureType;
use App\Service\FileUploader;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/annonce')]
class AnnonceController extends AbstractController
{
   

    /*#[Route("/detail/{id}", name: "annonce_detail")]

    /**
     * @Route("Route", name="RouteName")
     */
   /* public function detail(): Response
    {
        return $this->render('detail.html.twig', []);
    }*/

    #[Route('/annonce/Detail', name: 'annonce_detail')]
    public function show(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $a = new Annonce();
        $form = $this->createForm(AnnonceType::class, $a
        , array('action' => $this->generateUrl('annonce_detail')));
        $data['form'] = $form->createView();

        $data['annonces'] = $entityManager->getRepository(Annonce::class)->findAll();
        return $this->render('annonce/detail.html.twig',$data);
    }

    #[Route('/', name: 'annonce_index', methods: ['GET'])]
    /**
     * @Route("Route", name="RouteName")
     */
    public function index(AnnonceRepository $annonce): Response
    {
        return $this->render('annonce/index.html.twig', [
            'annonce' => $annonce->findAll(),
        ]);
    }
    /* ajout du bien */

    

    #[Route('Annonce/new', name: 'annonce', methods: ['GET', 'POST'])]
    /**
     * @Route("Route", name="RouteName")
     */
    public function new(Request $request,EntityManagerInterface $entityManager,FileUploader $fileUploader): Response
    { 

        $annonce = new Annonce();
        $form =$this->createForm(AnnonceType::class,$annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $imageFile =$form->get('photoAnnonce')->getData();

            if ($imageFile) {
                $imageFileName=$fileUploader->upload($imageFile);
                $annonce->setPhotoAnnonce($imageFileName);
            }
            $user = $this->getUser();
            $p= new User();
           // $p->setId($user->getId());
            //$p->getId($user->getId());
           // $p->setCni($user->getCni());
           // $p->setEmail($user->getEmail());
           // $p->setTelephone($user->getTelephone());
           // $p->setNom($user->getNom());
           // $p->setPrenom($user->getPrenom());
           // $p->setPassword($user->getPassword());
           // $p->setAdresses($user->getAdresses());
            //$p->setRoles($user->getRoles());
           // $p->setProprietaire($user);


           // $entityManager->merge($p);

          // $bien->setUsers($this->getUser());
          //$annonce->setUsers($this->getUser());

          //$user =$this->getUser();
          $entityManager->persist($annonce);
          $entityManager->flush();

          return $this->redirectToRoute('annonce_index',[],Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('annonce/new.html.twig',[
            'annonce'=>$annonce,
            'form'=>$form,
        ]);
    }



}