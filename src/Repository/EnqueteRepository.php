<?php

namespace AcMarche\EnquetePublique\Repository;

use AcMarche\EnquetePublique\Doctrine\OrmCrudTrait;
use AcMarche\EnquetePublique\Entity\Enquete;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Enquete|null find($id, $lockMode = null, $lockVersion = null)
 * @method Enquete|null findOneBy(array $criteria, array $orderBy = null)
 * @method Enquete[]    findAll()
 * @method Enquete[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EnqueteRepository extends ServiceEntityRepository
{
    use OrmCrudTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enquete::class);
    }

    /**
     * @return array|Enquete[]
     */
    public function findAllPublished()
    {
        $qb = $this->createQueryBuilder('enquete')
            ->leftJoin('enquete.documents', 'documents', 'WITH')
            ->leftJoin('enquete.categorie', 'categorie', 'WITH');

        $today = new DateTime();

        $qb->andWhere('enquete.date_fin > :date AND enquete.date_debut <= :date ')
            ->setParameter('date', $today->format('Y-m-d'));

        return
            $qb
                ->addOrderBy('enquete.date_debut', 'ASC')
                ->getQuery()
                ->getResult();
    }

    /**
     * @return array|Enquete[]
     */
    public function findAllSorted(): array
    {
        return
            $this->createQueryBuilder('enquete')
                ->addOrderBy('enquete.nom', 'ASC')
                ->getQuery()
                ->getResult();
    }

    public function findOrderByDate()
    {
        return
            $this->createQueryBuilder('enquete')
                ->addOrderBy('enquete.date_fin', 'DESC')
                ->getQuery()
                ->getResult();
    }
}
