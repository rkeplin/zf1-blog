<?php
namespace Blog\Walker;

use Doctrine\ORM\Query;

class Paginate
{
    static public function count(Query $query)
    {
        /* @var $countQuery Query */
        $countQuery = clone $query;

        $countQuery->setHint(Query::HINT_CUSTOM_TREE_WALKERS, array('DoctrineExtensions\Paginate\CountWalker'));
        $countQuery->setFirstResult(null)->setMaxResults(null);
        $countQuery->setParameters($query->getParameters());
        
        return $countQuery->getSingleScalarResult();
    }
}
