<?php
namespace Blog\Entity;

/**
 * @Entity(repositoryClass="Blog\Entity\Repository\QuoteRepository")
 * @Table(name="quotes")
 */
class Quote extends Base
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
    protected $quote;

    /**
     * @Column(type="string", length="100")
     */
    protected $author;

    /**
     * @Column(type="integer")
     */
    protected $year;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setQuote($quote)
    {
        $this->quote = $quote;
    }

    public function getQuote()
    {
        return $this->quote;
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getYear()
    {
        return $this->year;
    }
}