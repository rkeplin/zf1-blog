<?php
namespace Blog\Entity;

/**
 * @Entity(repositoryClass="Blog\Entity\Repository\CategoryRepository")
 * @Table(name="categories")
 */
class Category extends Base
{
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

    /**
     * @OneToMany(targetEntity="Blog\Entity\Post", mappedBy="category")
     */
    protected $posts;

    protected $num_posts;

    public function __construct()
    {
        $this->posts = new \Doctrine\Common\Collections\ArrayCollection();
    }

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

    public function setPosts($posts)
    {
        $this->posts = $posts;
    }

    public function getPosts()
    {
        return $this->posts;
    }

    public function setNumPosts($num_posts)
    {
        $this->num_posts = $num_posts;
    }

    public function getNumPosts()
    {
        return $this->num_posts;
    }
}