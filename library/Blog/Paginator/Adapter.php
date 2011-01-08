<?php
namespace Blog\Paginator;

use \Doctrine\ORM\Query,
    \Blog\Walker\Paginate;

class Adapter implements \Zend_Paginator_Adapter_Interface
{
    protected $_query;
    protected $_row_count;

    public function __construct(Query $query)
    {
        $this->_query = $query;
    }

    public function getItems($offset, $itemCountPerPage)
    {
        $query = $this->_query->setMaxResults($itemCountPerPage)->setFirstResult($offset);

        return $query->getResult();
    }

    public function count()
    {
        if($this->_row_count == null)
        {
            $this->_row_count = Paginate::count($this->_query);
        }

        return $this->_row_count;
    }
}
