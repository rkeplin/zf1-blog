<?php
namespace Blog\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    Blog\Entity\Role;

class QuoteRepository extends EntityRepository
{
    public function getRandom()
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('Blog\Entity\Quote', 'q');
        $rsm->addFieldResult('q', 'id', 'id');
        $rsm->addFieldResult('q', 'quote', 'quote');
        $rsm->addFieldResult('q', 'author', 'author');
        $rsm->addFieldResult('q', 'year', 'year');

        $sql = 'SELECT q.id, q.quote, q.author, q.year
                FROM quotes q
                ORDER BY RAND()
                LIMIT 1';

        $q = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $obj = $q->getSingleResult();
        
        return $obj;
    }
}