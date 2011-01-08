<?php
namespace Blog\Entity;

/**
 * @Entity(repositoryClass="Blog\Entity\Repository\PostRepository")
 * @Table(name="posts")
 */
class Post extends Base
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @Column(type="string", length=255)
     */
    protected $title;

    /**
     * @Column(type="string", length="9999")
     */
    protected $content;

    /**
     * @Column(type="datetime")
     */
    protected $date_added;

    /**
     * @Column(type="datetime")
     */
    protected $date_modified;

    /**
     * @Column(type="smallint")
     */
    protected $is_published;

    /**
     * @OneToOne(targetEntity="Blog\Entity\User")
     * @JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ManyToOne(targetEntity="Blog\Entity\Category", inversedBy="posts")
     * @JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;

    /**
     * @OneToMany(targetEntity="Blog\Entity\Comment", mappedBy="post")
     * @JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $comments;

    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setDateAdded($date_added)
    {
        $this->date_added = $date_added;
    }

    public function getDateAdded()
    {
        return $this->date_added;
    }

    public function setDateModified($date_modified)
    {
        $this->date_modified = $date_modified;
    }

    public function getDateModified()
    {
        return $this->date_modified;
    }

    public function setIsPublished($is_published)
    {
        $this->is_published = $is_published;
    }

    public function getIsPublished()
    {
        return $this->is_published;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    public function getComments()
    {
        return $this->comments;
    }
}