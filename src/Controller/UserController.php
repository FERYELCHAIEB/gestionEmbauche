<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Form\RegistrationFormType;
class UserController extends AbstractController
{
    /**
     * @Route("/user", name="userGestion")
     */
    public function index(): Response
    {$users = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users,
        ]);
    }
/**
          * @Route("/supprimer/user/{id}", name="supprimerUser")
     */
    public function supprimer(int $id):Response
    {  $entityManager = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository(User::class)->findBy(array('id'=>$id));
        if(! $user){
            throw $this->createNotFoundExpectation(
                'pas de user avec cet id|'.$id
            );
        }
        $entityManager->remove($user[0]);
        $entityManager->flush();
        return $this->redirectToRoute('userGestion');
     } 

      /**
        * @Route("/modifierUser/{id}",name="modifierUser")
     */
    public function modifier(int $id): Response

       { 
        $entityManager=$this->getDoctrine()->getManager();
        $user=$this->getDoctrine()->getRepository(User::class)->findBy(array('id'=>$id));
        if(! $user){
            throw $this->createNotFoundException(
                'pas de users avec cette id'.$id
            );
        }
   $user[0]->setValidation('ok') ;
   $entityManager->flush() ;
   return $this->redirectToRoute('userGestion',['id'=>$id]);
    }
}
