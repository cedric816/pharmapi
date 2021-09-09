<?php

namespace App\Repository;

use App\Entity\Pharmacie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pharmacie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pharmacie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pharmacie[]    findAll()
 * @method Pharmacie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PharmacieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pharmacie::class);
    }

    public function findGarde()
    {
        $jour = '';
        $numeroJour = date('N');
        switch ($numeroJour) {
            case 1:
                $jour = '%lundi%';
                break;
            case 2:
                $jour = '%mardi%';
                break;
            case 3:
                $jour = '%mrecredi%';
                break;
            case 4:
                $jour = '%jeudi%';
                break;
            case 5:
                $jour = '%vendredi%';
                break;
            case 6:
                $jour = '%samedi%';
                break;
            case 7:
                $jour = '%dimanche%';
                break;
        }
        return $this->createQueryBuilder('p')
            ->andWhere('p.garde LIKE :val')
            ->setParameter('val', $jour)
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Pharmacie[] Returns an array of Pharmacie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pharmacie
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
