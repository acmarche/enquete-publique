<?php

namespace AcMarche\EnquetePublique\Repository;

use AcMarche\EnquetePublique\Doctrine\OrmCrudTrait;
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
    use OrmCrudTrait;

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

}
