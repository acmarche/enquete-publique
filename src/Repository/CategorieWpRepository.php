<?php

namespace AcMarche\EnquetePublique\Repository;

use AcMarche\EnquetePublique\Entity\CategorieWp;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CategorieWp|null find($id, $lockMode = null, $lockVersion = null)
 * @method CategorieWp|null findOneBy(array $criteria, array $orderBy = null)
 * @method CategorieWp[]    findAll()
 * @method CategorieWp[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorieWpRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CategorieWp::class);
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

    public function remove(CategorieWp $categorie): void
    {
        $this->_em->remove($categorie);
    }

    public function flush(): void
    {
        $this->_em->flush();
    }

    public function persist(CategorieWp $categorie): void
    {
        $this->_em->persist($categorie);
    }
}
