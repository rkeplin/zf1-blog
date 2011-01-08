<?php
namespace Blog\Entity;

/**
 * @Entity(repositoryClass="Blog\Entity\Repository\CommentRepository")
 * @Table(name="comments")
 */
class Comment extends Base
{
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    protected $id;

    /**
     * @Column(type="integer")
     */
    protected $parent_id;

    /**
     * @Column(type="string", length="100")
     */
    protected $name;

    /**
     * @Column(type="string", length=255)
     */
    protected $email;

    /**
     * @Column(type="string", length=255)
     */
    protected $website;

    /**
     * @Column(type="string", length=100)
     */
    protected $ip_address;

    /**
     * @Column(type="string", length="9999")
     */
    protected $comment;

    /**
     * @Column(type="datetime")
     */
    protected $date_added;

    /**
     * @Column(type="smallint")
     */
    protected $status;

    /**
     * @OneToOne(targetEntity="Blog\Entity\Post", inversedBy="comments")
     * @JoinColumn(name="post_id", referencedColumnName="id")
     */
    protected $post;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setParentId($parent_id)
    {
        $this->parent_id = $parent_id;
    }

    public function getParentId()
    {
        return $this->parent_id;
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

    public function setWebsite($website)
    {
        $this->website = $website;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function setIpAddress($ip_address)
    {
        $this->ip_address = $ip_address;
    }

    public function getIpAddress()
    {
        return $this->ip_address;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setDateAdded($date_added)
    {
        $this->date_added = $date_added;
    }

    public function getDateAdded()
    {
        return $this->date_added;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setPost($post)
    {
        $this->post = $post;
    }

    public function getPost()
    {
        return $this->post;
    }
}