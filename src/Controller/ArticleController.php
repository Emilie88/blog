<?php

namespace App\Controller;


use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ArticleController extends AbstractController
{
     
    
    /**
     * @Route("/article/add", name="add-article")
     *  @IsGranted("ROLE_USER")
     */

    public function create(Request $request,EntityManagerInterface $manager){
        $article = new Article();
        $form = $this->createForm(ArticleType::class ,$article);
       
        $form ->handleRequest($request);  
        if($form->isSubmitted() && $form->isValid())
        {
            $image = $form['image']->getData();
            if($image){
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                try {
                    $image->move(
                        $this->getParameter('image_article_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    dd('Oups..');
                }

                
                $article->setImage($newFilename);
            }
          $article->setCreatedAt(new \DateTime());
          $article->setAuthor($this->getUser());
         

          $manager->persist($article);
          $manager->flush();
          //creer (enregistrer dans la session)un message flushbag
          $this->addFlash('success', 'Article Crée! ');

          //faire une redirection vers la page d'accueil
          return $this->redirectToRoute('home');
        }
        return $this->render('article/form.html.twig',['form'=>$form->createView()]);

    }
    /**
     * @Route("/article/{id}", name="view-article")
     */
    public function index(Article $article)
    {
      
        return $this->render('home/index.html.twig', [
            'articles' => $article,
        ]);
       
    }
   
}
