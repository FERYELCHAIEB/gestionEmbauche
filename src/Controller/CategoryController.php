<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{   
     /**
     * @Route("/categorie", name="consulterCategorie")
     */
    public function index(): Response
    { 

        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();

        return $this->render('category/template.html.twig', [
            'categories' => $categories,
        ]);
    }
    /**
     * @Route("/categorie/{id}", name="afficheCategorieById")
     */
    public function afficher(int $id): Response
    {  
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findBy(array('id'=>$id));
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
        ]);
    } 
     /**
     * @Route("/categorie/modifier/{id}", name="modifierCategorie")
     */
    public function modifier(int $id, Request $request): Response

       { 
        $repo = $this->getDoctrine()->getRepository(Categorie::class);
        $categorie = $repo->find($id);
        $form= $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();
            return $this->redirectToRoute('consulterCategorie');
        }
        return $this->render('category/modifier.html.twig', [
            'form' => $form->createView()
        ]);
        
    }
     /**
     * @Route("/supprimerCategorie/{id}", name="supprimerCategorie")
     */
    public function Supprimer(int $id):Response
    
    { 
         $entityManager = $this->getDoctrine()->getManager();

        $categorie = $this->getDoctrine()->getRepository(Categorie::class)->findBy(array('id'=>$id));
        if(! $categorie){
            throw $this->createNotFoundExpectation(
                'pas de categorie avec la marticule|'.$id
            );
        }
        $entityManager->remove($categorie[0]);
        $entityManager->flush();
        return $this->redirectToRoute('consulterCategorie');
    }
     /**
     * @Route("/createCategorie", name="createCategorie")
     */
    public function createCategorie( Request $request ):Response
    {   
        $categorie = new Categorie();
        $form= $this->createForm(CategoryType::class, $categorie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorie);
            $entityManager->flush();

            return $this->redirectToRoute('consulterCategorie');
        }
        return $this->render('category/ajouter.html.twig', [
            'form' => $form->createView()
        ]);
    }    }
   

    

