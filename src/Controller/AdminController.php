<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Candidat;
class AdminController extends AbstractController
{ /**
    * @Route("/admin/user", name="gestionUser")
    */
   public function index(): Response
   {
      $entityManager=$this->getDoctrine()->getManager();
       $users =  $entityManager->getRepository(User::class)->findAll();
       
      
       return $this->render('admin/user.html.twig', [
         
           
           'users' => $users,
           
          
       ]);
   }
    /**
    * @Route("/admin/candidat", name="gestionCandidat")
    */
    public function candidat(): Response
    {
       $entityManager=$this->getDoctrine()->getManager();
        $candidats =  $entityManager->getRepository(Candidat::class)->findAll();
        
       
        return $this->render('admin/candidat.html.twig', [
          
            
            'candidats' => $candidats,
            
           
        ]);
    }
}