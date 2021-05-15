<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Candidate;
class AdminController extends AbstractController
{  /**
    * @Route("/admin", name="profilAdmin")
    */
    
    public function index(): Response
   {
     
       
      
       return $this->render('admin/index.html.twig');
   }
    
    /**
    * @Route("/admin/user", name="gestionUser")
    */
   public function user(): Response
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
        $candidats =  $entityManager->getRepository(Candidate::class)->findAll();
        
       
        return $this->render('admin/candidat.html.twig', [
          
            
            'candidats' => $candidats,
            
           
        ]);
    }
}