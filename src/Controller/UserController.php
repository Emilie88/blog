<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Form\UserConnectType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class UserController extends AbstractController
{
    /**
     * @Route("/deconnexion", name="user_deconnect")
     */

    public function user_deconnect(){


    }

    /**
     * @Route("/connexion", name="user_connect")
     */

    public function user_connect(){
        
        return $this->render('user/connect.html.twig',['form'=>$this->createForm(UserConnectType::class)->createView()]);
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        // $user = $this->getUser();
        // $this->addFlash('Well hi there '.$user->getFirstName());
        

    }
    /**
     * @Route("/user", name="user_register")
     */

    public function user_register(Request $request,EntityManagerInterface $manager,UserPasswordEncoderInterface $encoder){
        $user = new User();
        $form = $this->createForm(UserType::class,$user);
        $form ->handleRequest($request);  
        if($form->isSubmitted() && $form->isValid()){
            $user->setRoles(['ROLE_USER']);
            $user->setCreatedAt(new \DateTime());
            
            $user->setPassword($encoder->encodePassword($user, $user->getPassword()));

            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Compte Crée! ');
            return $this->redirectToRoute('home');
        }
        return $this->render('user/register.html.twig',['form'=>$form->createView()]);

    }
   
    
   
}
