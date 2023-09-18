<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Utilisateur;
use App\Entity\Article;


class AppFixtures extends Fixture
{
        public function load(ObjectManager $manager)
        {
            // $product = new Product();
            // $manager->persist($product);
            for ($i = 0; $i < 5; $i++) {
                $categorie = new Categorie();
                $categorie->setType('categorie ');
                $manager->persist($categorie);

            $manager->flush();
            }
            for ($i = 0; $i < 5; $i++) {
                $utilisateur = new Utilisateur();
                $utilisateur->setPseudo('utilisateur '.$i);
                $manager->persist($utilisateur);

            $manager->flush();
            }
            for ($i = 0; $i < 10; $i++) {
                $article = new Article();
                $article->setTexte('article '.$i);
                $article->setUtilisateur($utilisateur);
                $article->setCategorie($categorie);
                $article->setTitre('titre'.$i);
                $manager->persist($article);

            $manager->flush();
            }
        }

}