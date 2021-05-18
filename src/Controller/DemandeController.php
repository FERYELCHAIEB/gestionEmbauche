<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Demande;
use App\Entity\Categorie;
use App\Form\DemandeType;

class DemandeController extends AbstractController
{ 
    /**
     * @Route("/demande", name="demande")
     */
    public function index(): Response
    {$demande = $this->getDoctrine()->getRepository(Demande::class)->findAll();
        return $this->render('demande/index.html.twig', [
            'demande' => $demande,
        ]);
    }
    /**
     * @Route("/demande/{id}", name="afficheDemandeById")
     */
    public function afficher(int $id): Response
    {  
        $demande = $this->getDoctrine()->getRepository(Demande::class)->findBy(array('id'=>$id));
        return $this->render('demande/consulter.html.twig', [
            'demande' => $demande,
        ]);
    } 
    /**
     * @Route("/demande/modifier/{id}", name="modifierDemande")
     */
    public function modifier(int $id, Request $request): Response

       { 
        $repo = $this->getDoctrine()->getRepository(Demande::class);
        $demande = $repo->find($id);
        $form= $this->createForm(DemandeType::class, $demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($demande);
            $em->flush();
            return $this->redirectToRoute('demande');
        }
        return $this->render('demande/modifier.html.twig', [
            'form' => $form->createView()
        ]);
        
    }

    /**
     * @Route("/supprimerdemande/{id}", name="supprimerDemande")
     */
    public function Supprimer(int $id):Response
    
    {
         $entityManager = $this->getDoctrine()->getManager();

        $demande = $this->getDoctrine()->getRepository(Demande::class)->findBy(array('id'=>$id));
        if(! $demande){
            throw $this->createNotFoundExpectation(
                'pas de demande avec id|'.$id
            );
        }
        $entityManager->remove($demande[0]);
        $entityManager->flush();
        return $this->redirectToRoute('demande');
    }

      /**
     * @Route("/demandeCreate", name="demandeCreate")
     */
    public function createCandid(Request $request):Response{
        $category= new Categorie();
        $demande=new Demande();
        $form = $this->createForm(DemandeType::class,$demande);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $category =$form->getData();
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($demande);
            $entityManager->flush();
            return $this->redirectToRoute('demande');
        }
        return $this->render('demande/ajouter.html.twig', [
            'form' => $form ->createView()
        ]);
           
       
    }
}
