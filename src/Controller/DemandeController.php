<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Demande;
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
     * @Route("/demandeCreate", name="demandeCreate")
     */
    public function createCandid(Request $request):Response{
      
        $demande=new Demande();
        $form = $this->createForm(DemandeType::class,$demande);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           
           
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
