<?php
namespace Blog\Entity;

/**
 * @Entity(repositoryClass="Blog\Entity\Repository\UserRepository")
 * @Table(name="users")
 */
class User extends Base implements \Zend_Acl_Role_Interface
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @Column(type="string", length=50)
     */
    protected $name;

    /**
     * @Column(type="string", length=250)
     */
    protected $email;

    /**
     * @Column(type="string", length=250)
     */
    protected $password;

    /**
     * @OneToOne(targetEntity="Blog\Entity\Role")
     * @JoinColumn(name="role_id", referencedColumnName="id")
     * @Cascade=PERSIST
     */
    protected $role;

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

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getRoleId()
    {
        if(is_object($this->getRole()))
        {
            return $this->getRole()->getId();
        }

        return \Blog\Entity\Role::GUEST;
    }
}