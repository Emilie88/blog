<?php

namespace App\DataFixtures;

use App\Entity\Article;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 52; $i++ ){
            $post = new Article();
            $post ->setTitle('Article n° ' .$i);
            $post ->setContent('Contenu ('.$i.')');
            $post ->setImage('https://i.picsum.photos/id/2'.$i.'/800.jpg');
            $post ->setCreatedAt(new DateTime());

            $manager->persist($post);

      

        }

        $manager->flush();

       
    }
}
