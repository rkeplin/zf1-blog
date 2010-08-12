<?php
class Model_Mapper_Quote 
    extends Keplin_Model_Mapper_Abstract
{
    public function save(Model_Quote $quote)
    {
        if($quote->id)
        {
            $where[] = 'id = ' . $quote->id;
            $this->_db->update('quotes', $quote->toArray(), $where);
        }
        else
        {
            $this->_db->insert('quotes', $quote->toArray());
            $quote->id = $this->_db->lastInsertId();
        }
        
        return $quote;
    }
    
    public function getQuote()
    {
        $select = $this->_db->select()->from(array('q' => 'quotes'))->order('RAND()')->limit(1);
        $quote = $this->_db->fetchRow($select);
        
        return new Model_Quote($quote);
    }
    
    public function getPaged($page = 1)
    {
        $select = $this->_db->select()->from(array('q' => 'quotes'), array('id', 'quote', 'author', 'year'));
        
        $adapter = new Keplin_Paginator_Adapter('Model_QuoteCollection', $select);
        $paginator = new Zend_Paginator($adapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setItemCountPerPage(10);
        
        return $paginator;
    }
}