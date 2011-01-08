<?php
namespace Blog\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    Blog\Entity\Comment;

class CommentRepository extends EntityRepository
{
    public function fetchPaged($page = 1)
    {
        $dql = 'SELECT c
                FROM Blog\Entity\Comment c
                ORDER BY c.date_added DESC';
        $q = $this->getEntityManager()->createQuery($dql);

        $adapter = new \Blog\Paginator\Adapter($q);

        $paginator = new \Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }

    public function delete($id)
    {
        $em = $this->getEntityManager();
        $proxy = $em->getReference('Blog\Entity\Comment', $id);

        $em->remove($proxy);
    }
}