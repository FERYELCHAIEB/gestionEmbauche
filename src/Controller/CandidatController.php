<?php 

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Candidate;
use App\Form\CandidatType; 
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
class CandidatController extends AbstractController
{   /**
    * @Route("/home", name="candidatProfil")
    */
    public function home(): Response{
        return $this->render('candidat/home.html.twig');
    } 

    /**
     * @Route("/candidat", name="candidat")
     */
    public function index(): Response 
    {$candidat = $this->getDoctrine()->getRepository(Candidate::class)->findAll();
        return $this->render('candidat/index.html.twig', [
            'candidat' => $candidat,
        ]);
    }
     /**
          * @Route("/supprimer/candidat/{id}", name="supprimerCandidat")
     */
    public function supprimer(int $id):Response
    {  $entityManager = $this->getDoctrine()->getManager();
        $candidat = $this->getDoctrine()->getRepository(Candidate::class)->findBy(array('id'=>$id));
        if(! $candidat){
            throw $this->createNotFoundExpectation(
                'pas de candidat avec cet id|'.$id
            );
        }
        $entityManager->remove($candidat[0]);
        $entityManager->flush();
        return $this->redirectToRoute('candidat');
     } 
   /**
     * @Route("/connexion", name="candid_login")
     */
    public function connexion(AuthenticationUtils $authenticationUtils): Response
    {
         //if ($this->getUser()) {
         //   return $this->render('candidatProfil');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/connexion.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    /**
     * @Route("/Inscription", name="inscriptionCandidat")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $candid = new Candidate();
        $form = $this->createForm(CandidatType::class, $candid);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $candid->setPassword(
                $passwordEncoder->encodePassword(
                    $candid,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($candid);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('candid_login');
        }

        return $this->render('candidat/ajouter.html.twig', [
            'InscriptionForm' => $form->createView(),
        ]);
    }
    
    

}
