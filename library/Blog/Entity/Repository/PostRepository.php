<?php
namespace Blog\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    Doctrine\ORM\Query\ResultSetMapping,
    Blog\Entity\Post;

class PostRepository extends EntityRepository
{
    public function getLatest()
    {
        $dql = 'SELECT p 
                FROM Blog\Entity\Post p 
                WHERE p.is_published = 1 
                ORDER BY p.date_added DESC';
        
        $q = $this->getEntityManager()->createQuery($dql);
        $q->setMaxResults(1);
        
        $post = $q->getSingleResult();
        
        return $post;
    }

    public function getRecent($limit = 5)
    {
        $dql = 'SELECT partial p.{id, title}, partial c.{id, name}
                FROM Blog\Entity\Post p
                JOIN p.category c
                WHERE p.is_published = 1
                ORDER BY p.date_added DESC';
        
        $q = $this->getEntityManager()->createQuery($dql);
        $q->setMaxResults($limit);

        $posts = $q->getResult();
        
        return $posts;
    }

    public function fetchValidYears()
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('Blog\Entity\Post', 'p');
        $rsm->addScalarResult('max_year', 'max_year');
        $rsm->addScalarResult('min_year', 'min_year');

        $sql = 'SELECT YEAR(MIN(p.date_added)) AS min_year, YEAR(MAX(p.date_added)) AS max_year
                FROM posts p
                WHERE p.is_published = 1';
        $q = $this->getEntityManager()->createNativeQuery($sql, $rsm);
        $years = $q->getSingleResult();
        
        return $years;
    }

    public function getFromArchive($year, $page = 1)
    {
        $dql = 'SELECT partial p.{id, title}, partial c.{id, name}
                FROM Blog\Entity\Post p
                JOIN p.category c
                WHERE p.is_published = 1
                AND YEAR(p.date_added) = ?1
                ORDER BY p.date_added DESC';
        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameter(1, $year);

        $adapter = new \Blog\Paginator\Adapter($q);

        $paginator = new \Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);
        
        return $paginator;
    }

    public function getFromCategory($category, $page = 1)
    {
        $dql = 'SELECT partial p.{id, title}, partial c.{id, name}
                FROM Blog\Entity\Post p
                JOIN p.category c
                WHERE p.is_published = 1
                AND c.name = ?1
                ORDER BY p.date_added DESC';
        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameter(1, $category);

        $adapter = new \Blog\Paginator\Adapter($q);

        $paginator = new \Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }

    public function getPaged($page = 1)
    {
        $dql = 'SELECT partial p.{id, title, is_published, date_added, date_modified}, partial c.{id, name}
                FROM Blog\Entity\Post p
                JOIN p.category c
                ORDER BY p.date_modified DESC';
        $q = $this->getEntityManager()->createQuery($dql);

        $adapter = new \Blog\Paginator\Adapter($q);

        $paginator = new \Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }

    public function search($data, $page = 1)
    {
        $dql = 'SELECT partial p.{id, title, content, is_published, date_added, date_modified}, partial c.{id, name}
                FROM Blog\Entity\Post p
                JOIN p.category c
                WHERE p.is_published = 1 ';

        if(isset($data['query']))
        {
            $dql .= ' AND (p.title LIKE ?1
                      OR p.content LIKE ?1)';
        }

        if(isset($data['category']))
        {
            $dql .= ' AND c.name = ?2';
        }

        if(isset($data['year']))
        {
            $dql .= ' AND YEAR(p.date_added) = ?3';
        }

        $dql .= ' ORDER BY p.date_modified DESC';

        $q = $this->getEntityManager()->createQuery($dql);

        if(isset($data['query']))
        {
            $q->setParameter(1, $data['query']);
        }

        if(isset($data['category']))
        {
            $q->setParameter(2, $data['category']);
        }

        if(isset($data['year']))
        {
            $q->setParameter(3, $data['year']);
        }

        $adapter = new \Blog\Paginator\Adapter($q);

        $paginator = new \Zend_Paginator($adapter);
        $paginator->setItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return $paginator;
    }

    public function getFromTitle($title)
    {
        $dql = 'SELECT p
                FROM Blog\Entity\Post p
                JOIN p.category c
                WHERE p.title = ?1';
        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameter(1, $title);

        $post = $q->getSingleResult();

        return $post;
    }

    public function getRss()
    {
        $dql = 'SELECT partial p.{id, title, content}, partial c.{id, name}
                FROM Blog\Entity\Post p
                JOIN p.category c
                WHERE p.is_published = 1
                ORDER BY p.date_added DESC';
        $q = $this->getEntityManager()->createQuery($dql);

        $posts = $q->getResult();

        return $posts;
    }

    public function getPost($id)
    {
        $dql = 'SELECT p
                FROM Blog\Entity\Post p
                JOIN p.category c
                WHERE p.id = ?1';
        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameter(1, $id);

        $post = $q->getSingleResult();

        return $post;
    }
}