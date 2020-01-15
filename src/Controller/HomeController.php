<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArticleRepository $repo, Request $request)
    {   
        if($request->isMethod('post')) {
            $articles = $repo->search($request->request->get('search'));
        } else {
            $articles = $repo->findAll();
        }     

        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }

      
}


