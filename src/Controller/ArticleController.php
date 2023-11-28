<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categorie;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/article')]
class ArticleController extends AbstractController
{
    #[Route('/', name: 'app_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_article_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_show', methods: ['GET'])]
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,
        ]);
    }

    #[IsGranted('POST_EDIT', 'article', 'Vous n\'avez pas les droits', 403)]
    #[Route('/{id}/edit', name: 'app_article_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_article_delete', methods: ['POST'])]
    public function delete(Request $request, Article $article, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$article->getId(), $request->request->get('_token'))) {
            $entityManager->remove($article);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_article_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/categorie/{slug}/articles', name: 'app_article_categorie', methods: ['GET'])]
    public function articleCategorie(ArticleRepository $articleRepository, Categorie $categorie): Response
{

        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findByCategorie($categorie),
        ]);
    }

    #[Route('/', name: 'app_article_dernier', methods: ['GET'])]
    public function dernierArticle(ArticleRepository $articleRepository): Response
    {
        return $this->render('dernierArticles.html.twig', [
            'articles' => $articleRepository->findDernierArticles(),
        ]);
    }

    #[Route('/resultat/r', name: 'app_article_search', methods: ['GET'])]
    public function motCle(ArticleRepository $articleRepository, Request $request): Response
    {
        $form = $request->get('form');
        $element = "%".$form['element']."%";
        return $this->render('article/index.html.twig', [
            'articles' => $articleRepository->findByMot($element),
        ]);
    }

    #[Route('/formulaire/f', name: 'app_article_form', methods: ['GET'])]
    public function form(Request $request): Response
    {
        $form = $this->createFormBuilder(null, [
            'attr' => ['class' => 'd-flex'],
        ])
        ->setAction($this->generateUrl('app_article_search'))
        ->add('element', TextType::class, ['label'=>false,
        'attr' => ['class' => 'form-control me-2',
                    'placeholder' => 'Chercher un article'],
        ])
        ->add('Chercher', SubmitType::class, ['label' => 'Rechercher',
            'attr' => ['class' => 'btn btn-outline-success']])
        ->setMethod('GET')
        ->getForm();

        return $this->render('article/form_recherche.html.twig', ['form' => $form->createView()]);
    }


    //TEST WYSIWYG
    // #[Route('/formulaire/test', name: 'app_article_formtest', methods: ['GET'])]
    // public function test(Request $request): Response
    // {
    //     $form = $this->createFormBuilder(null, [
    //         'attr' => ['class' => 'd-flex'],
    //     ])
        
        
    //         ->add('content', \Trsteel\CkeditorBundle\Form\Type\CkeditorType::class, array(
    //             'transformers'                 => array('html_purifier'),
    //             'toolbar'                      => array('document','basicstyles'),
    //             'toolbar_groups'               => array(
    //                 'document' => array('Source')
    //             ),
    //             'ui_color'                     => '#ffffff',
    //             'startup_outline_blocks'       => false,
    //             'width'                        => '100%',
    //             'height'                       => '320',
    //             'language'                     => 'fr_fr',
    //             'filebrowser_image_browse_url' => array(
    //                 'url' => 'relative-url.php?type=file',
    //             ),
                
    //         ))
    //     ->setMethod('GET')
    //     ->getForm();

    //     return $this->render('article/form_recherche.html.twig', ['form' => $form->createView()]);
    // }


    //TEST API
    #[Route('/{id}/API', name: 'app_article_api', methods: ['GET'])]
    public function articleAPI( Article $article, SerializerInterface $serializer): JsonResponse
    {
        
        
        $jsonArticle = $serializer->serialize($article, 'json',['groups' => 'group_json']); 
        $response = new JsonResponse($jsonArticle);
        return $response;

    }
   

}
