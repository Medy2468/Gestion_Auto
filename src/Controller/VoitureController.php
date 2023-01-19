<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Entity\User;
use App\Form\VoitureType;
use App\Service\FileUploader;
use App\Repository\VoitureRepository;
//use Symfony\Component\BrowserKit\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/voiture')]
class VoitureController extends AbstractController
{
 
    #[Route("/detail/{id}", name:"voiture_detail")]

/**
 * @Route("Route", name="RouteName")
 */
public function detail(): Response
{
    return $this->render('$0.html.twig', []);
}
    
    #[Route('/', name: 'voiture_index',methods:['GET'])]
    /**
     * @Route("Route", name="RouteName")
     */
    public function index(VoitureRepository $voitureRepository): Response
    {
        return $this->render('voiture/index.html.twig',[
            'voitures'=>$voitureRepository->findAll(),
        ]);
    }
    /* ajout du bien */

    #[Route('Voiture/new', name: 'voiture', methods: ['GET', 'POST'])]
    /**
     * @Route("Route", name="RouteName")
     */
    public function new(Request $request,EntityManagerInterface $entityManager,FileUploader $fileUploader): Response
    { 

        $voiture = new Voiture();
        $form =$this->createForm(VoitureType::class,$voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()) {
            $imageFile =$form->get('photoVoiture')->getData();

            if ($imageFile) {
                $imageFileName=$fileUploader->upload($imageFile);
                $voiture->setphotoVoiture($imageFileName);
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
           $voiture->setUsers($this->getUser());

          //$user =$this->getUser();
          $entityManager->persist($voiture);
          $entityManager->flush();

          return $this->redirectToRoute('voiture_index',[],Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voiture/new.html.twig',[
            'voiture'=>$voiture,
            'form'=>$form,
        ]);
    }


    
    #[Route('/{id}/edit', name: 'voiture_edit', methods: ['GET', 'POST'])]
    /**
     * @Route("Route", name="RouteName")
     */
    public function edit(Request $request, Voiture $voiture,EntityManagerInterface $entityManager,FileUploader $fileUploader): Response
    {
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Voiture ajouter avec succes');
            $imageEditFile = $form->get('photoVoiture')->getData();
            if(!$imageEditFile) {
                $voiture->setphotoVoiture(
                    new File($this->getParameter('photoVoiture_directory').'/'.$voiture->getphotoVoiture())
                );
            }else {
                    $imageFileName = $fileUploader->upload($imageEditFile);
                    $voiture->setphotoVoiture($imageFileName);
            }
            $entityManager->flush();
            return $this->redirectToRoute('voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voiture/edit.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    /* methode delete */
    #[Route('/{id}', name: 'voiture_delete', methods: ['POST'])]
    public function delete(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($voiture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('voiture_index', [], Response::HTTP_SEE_OTHER);
    }
}


