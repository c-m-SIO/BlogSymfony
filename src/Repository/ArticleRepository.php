<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

//    /**
//     * @return Article[] Returns an array of Article objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Article
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    public function findByCategorie($categorie): ?array
    {
       // dd($categorie);
        return $this->createQueryBuilder('a')
            ->join('a.categorie', 'c')
            ->andWhere('c.id = :categorie')
            ->setParameter('categorie', $categorie)
            ->orderBy('a.texte', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findDernierArticles(): array
   {
       return $this->createQueryBuilder('a')
           
           ->orderBy('a.id', 'DESC')
           ->setMaxResults(3)
           ->getQuery()
           ->getResult()
       ;
   }

   public function findByMot($mot): array
   {
       return $this->createQueryBuilder('a')
    
            ->setParameter('mot', $mot)
           ->orderBy('a.id', 'DESC')
           ->andWhere('a.Titre like :mot or a.texte like :mot')
           ->getQuery()
           ->getResult()
       ;
   }
}
