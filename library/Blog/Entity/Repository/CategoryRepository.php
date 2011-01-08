<?php
namespace Blog\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    Blog\Entity\Category;

class CategoryRepository extends EntityRepository
{
    public function fetchAll()
    {
        $dql = 'SELECT partial c.{id, name}
                FROM Blog\Entity\Category c
                JOIN c.posts p
                WHERE p.is_published = 1
                ORDER BY c.name ASC';

        $q = $this->getEntityManager()->createQuery($dql);

        $collection = $q->getResult();
        
        return $collection;
    }
}