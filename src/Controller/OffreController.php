<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Offre;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Form\OffreType;

class OffreController extends AbstractController
{   
     /**
     * @Route("/offre", name="consulterOffre")
     */
    public function index(): Response
    {  

        $offres = $this->getDoctrine()->getRepository(Offre::class)->findAll();

        return $this->render('offre/template.html.twig', [
            'offres' => $offres,
        ]);
    }
    /**
     * @Route("/offre/{id}", name="afficheOffreById")
     */
    public function afficher(int $id): Response
    {  
        $offres = $this->getDoctrine()->getRepository(Offre::class)->findBy(array('id'=>$id));
        return $this->render('offre/index.html.twig', [
            'offres' => $offres,
        ]);
    } 
     /**
     * @Route("/offre/modifier/{id}", name="modifierOffre")
     */
    public function modifier(int $id, Request $request): Response

       { 
        $repo = $this->getDoctrine()->getRepository(Offre::class);
        $offre = $repo->find($id);
        $form= $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute('consulterOffre');
        }
        return $this->render('offre/modifier.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
     /**
     * @Route("/supprimeroffre/{id}", name="supprimerOffre")
     */
    public function Supprimer(int $id):Response
    
    {
         $entityManager = $this->getDoctrine()->getManager();

        $offre = $this->getDoctrine()->getRepository(Offre::class)->findBy(array('id'=>$id));
        if(! $offre){
            throw $this->createNotFoundExpectation(
                'pas de offre avec id|'.$id
            );
        }
        $entityManager->remove($offre[0]);
        $entityManager->flush();
        return $this->redirectToRoute('consulterOffre');
    }
     /**
     * @Route("/createOffre", name="createOffre")
     */
    public function createOffre( Request $request ):Response
    {   $category= new Categorie();
       
        $offre = new Offre();
        $form= $this->createForm(OffreType::class, $offre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $offre->setEtat(1);
            $category =$form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('consulterOffre');
        }
        return $this->render('offre/ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/offre/changer/{id}", name="changerEtat")
     */
    public function change (int $id): Response

       { 
        $entityManager=$this->getDoctrine()->getManager();
        $offre=$this->getDoctrine()->getRepository(Offre::class)->findBy(array('id'=>$id));
        if(! $offre){
            throw $this->createNotFoundException(
                'pas de users avec cette id'.$id
            );
        }
   $offre[0]->setEtat('0') ;
   $entityManager->flush() ;
   return $this->redirectToRoute('consulterOffre',['id'=>$id]);
    }
   
}
    

