<?php

namespace App\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class AbstractRepository
 */
abstract class AbstractRepository extends ServiceEntityRepository
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * AbstractRepository constructor.
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, $this->getEntityClass());

        $this->em = $registry->getManagerForClass($this->getEntityClass());
    }

    /**
     * Get paginated items.
     *
     * @param int $page
     * @param int $resultsPerPage
     *
     * @return object[]
     */
    public function getPaginated($page, $resultsPerPage, array $filters = [])
    {
        $page = max((int) $page, 1);

        $qb = $this->buildQuery($filters);

        $qb->setMaxResults($resultsPerPage);
        $qb->setFirstResult(($page - 1) * $resultsPerPage);

        $ids = $this->getIds($qb);

        return $this->getItems($ids);
    }

    /**
     * Get the page count and total items count for this query.
     *
     * @param int $resultsPerPage
     *
     * @return array ['total' => x, 'pageCount' => x]
     */
    public function getPaginationData($resultsPerPage, array $filters = [])
    {
        $qb = $this->buildQuery($filters);

        $qb->select(sprintf('count(distinct %s.id) as total', $qb->getQueryPart('from')[0]['alias']));

        $total = $qb->executeQuery()->fetchOne();

        return [
            'total' => $total,
            'pageCount' => ceil($total / $resultsPerPage),
        ];
    }


    /**
     * @return mixed
     */
    abstract public function getEntityClass();

    /**
     * Get the ids for the current query builder.
     *
     * @return array
     */
    protected function getIds(QueryBuilder $qb)
    {
        $qb = clone $qb;
        $alias = $qb->getQueryPart('from')[0]['alias'];
        $qb
            ->select(sprintf('%s.id', $alias))
        ;

        if (empty($qb->getQueryPart('orderBy'))) {
            $qb->orderBy(sprintf('%s.id', $alias), 'DESC');
        }

        $ids = $qb->executeQuery()->fetchFirstColumn();

        return !empty($ids) ? $ids : [];
    }

    /**
     * Get items by their ids.
     *
     * @return object[]
     */
    protected function getItems(array $ids)
    {
        if (empty($ids)) {
            return [];
        }

        $qb = $this->em->createQueryBuilder();

        $qb
            ->select('e')
            ->from($this->getEntityClass(), 'e')
            ->where('e.id IN (:ids)')
            ->setParameter('ids', $ids)
        ;


        $results = $qb->getQuery()->getResult();

        if (empty($results)) {
            return [];
        }

        $unsorted = [];
        foreach ($results as $unit) {
            $unsorted[$unit->getId()] = $unit;
        }

        $sorted = [];
        foreach ($ids as $id) {
            if (isset($unsorted[$id])) {
                $sorted[] = $unsorted[$id];
            }
        }

        return $sorted;
    }


    /**
     * @return QueryBuilder
     */
    abstract protected function buildQuery(array $filters);
}
