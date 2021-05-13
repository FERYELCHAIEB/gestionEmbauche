<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Candidat;
use App\Form\CandidatType;
class CandidatController extends AbstractController
{
    /**
     * @Route("/candidat", name="candidat")
     */
    public function index(): Response
    {$candidat = $this->getDoctrine()->getRepository(Candidat::class)->findAll();
        return $this->render('candidat/index.html.twig', [
            'candidat' => $candidat,
        ]);
    }
     /**
          * @Route("/agence/candidat/{id}", name="supprimerCandidat")
     */
    public function supprimer(int $id):Response
    {  $entityManager = $this->getDoctrine()->getManager();
        $candidat = $this->getDoctrine()->getRepository(Candidat::class)->findBy(array('id'=>$id));
        if(! $candidat){
            throw $this->createNotFoundExpectation(
                'pas de voiture avec cet id|'.$id
            );
        }
        $entityManager->remove($candidat[0]);
        $entityManager->flush();
        return $this->redirectToRoute('candidat');
     } 
    /**
     * @Route("/candidatCreate", name="candidatCreate")
     */
    public function createCandid(Request $request):Response{
      
        $candidat=new Candidat();
        $form = $this->createForm(CandidatType::class,$candidat);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           
           
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candidat);
            $entityManager->flush();
            return $this->redirectToRoute('candidat');
        }
        return $this->render('candidat/ajouter.html.twig', [
            'form' => $form ->createView()
        ]);
           
       
    }

}
