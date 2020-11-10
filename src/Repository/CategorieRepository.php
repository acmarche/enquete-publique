<?php

namespace AcMarche\EnquetePublique\Repository;

use AcMarche\EnquetePublique\Entity\Categorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorie[]    findAll()
 * @method Categorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorie::class);
    }

    public function findAllSorted()
    {
        $qb = $this->createQueryBuilder('categorie');

        return
            $qb
                ->addOrderBy('categorie.nom', 'ASC')
                ->getQuery()
                ->getResult();
    }

    public function remove(Categorie $categorie)
    {
        $this->_em->remove($categorie);
    }

    public function flush()
    {
        $this->_em->flush();
    }

    public function persist(Categorie $categorie)
    {
        $this->_em->persist($categorie);
    }

}
