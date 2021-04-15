<?php

declare(strict_types=1);

namespace App\Repository;

use App\Doctrine\DQL\Walkers\MysqlPaginationWalker;
use App\Entity\Customer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Customer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Customer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Customer[]    findAll()
 * @method Customer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CustomerRepository extends ServiceEntityRepository
{
    private int $totalCount;
    
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Customer::class);
    }
    
    public function getTotalCount()
    {
        return $this->totalCount;
    }
    
    public function getList(int $limit, int $offset)
    {
        $qb = $this->createQueryBuilder('s');
        $qb->setFirstResult($offset);
        $qb->setMaxResults($limit);
    
        $query = $qb->getQuery();
        $query->setHint(
            Query::HINT_CUSTOM_OUTPUT_WALKER,
            MysqlPaginationWalker::class
        );
        $query->setHint("mysqlWalker.sqlCalcFoundRows", true);
    
        $customers = $query->getResult(AbstractQuery::HYDRATE_OBJECT);
        $this->totalCount = (int)$this->getEntityManager()->getConnection()->fetchFirstColumn('SELECT FOUND_ROWS()')[0];
    
        return $customers;
    }
}