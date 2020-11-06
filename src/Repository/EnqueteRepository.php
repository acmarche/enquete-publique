<?php

namespace AcMarche\EnquetePublique\Repository;

use AcMarche\EnquetePublique\Entity\Enquete;
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
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Enquete::class);
    }

    public function findAllSorted()
    {
        $qb = $this->createQueryBuilder('enquete');

        return
            $qb
                ->addOrderBy('enquete.nom', 'ASC')
                ->getQuery()
                ->getResult();
    }

    public function remove(Enquete $reduction)
    {
        $this->_em->remove($reduction);
    }

    public function flush()
    {
        $this->_em->flush();
    }

    public function persist(Enquete $reduction)
    {
        $this->_em->persist($reduction);
    }

}
