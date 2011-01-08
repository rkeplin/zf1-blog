<?php
namespace Blog\Entity;

/**
 * @Entity(repositoryClass="Blog\Entity\Repository\RoleRepository")
 * @Table(name="roles")
 */
class Role extends Base
{
    const ADMIN = '1';
    const GUEST = '2';
    
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @Column(type="string", length=100)
     */
    protected $name;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}