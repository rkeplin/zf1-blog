<?php
namespace Blog\Entity\Repository;

use Doctrine\ORM\EntityRepository,
    Blog\Entity\User;

class UserRepository extends EntityRepository
{
    public function auth(User $user)
    {
        $dql = 'SELECT u
                FROM Blog\Entity\User u
                WHERE u.email = ?1
                AND u.password = ?2';
        $q = $this->getEntityManager()->createQuery($dql);
        $q->setParameter(1, $user->getEmail());
        $q->setParameter(2, $user->getPassword());

        try
        {
            $temp_user = $q->getSingleResult();
            $user->setId($temp_user->getId());
            $user->setRole($temp_user->getRole());
        }
        catch(\Exception $e)
        {
            
        }

        return $user;
    }
}