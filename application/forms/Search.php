<?php
class Form_Search extends Keplin_Form_Abstract
{
    public function init()
    {
        $this->setMethod('get')
             ->setAction('/blog/search-handler/')
             ->setName('detailedsearch');
        
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => 'detailed-search-form.phtml')))
        );
        
        $this->addElement('text', 'query', array(
            'label' => 'Search',
            'required' => false 
        ));
        
        $this->addElement('select', 'category', array(
            'label' => 'Category',
            'multioptions' => $this->_getCategories(),
            'required' => false
        ));
        
        $this->addElement('select', 'year', array(
            'label' => 'Year',
            'multioptions' => $this->_getYears(),
            'required' => false
        ));
        
        $this->addElement('submit', 'submit_comment', array(
            'label' => 'Search'
        ));
    }
    
    public function _getCategories()
    {
        $mapper = new Model_Mapper_Category();
        $categories = $mapper->fetchAll();
        
        $array[0] = 'All Categories';
        
        foreach($categories as $category)
        {
            $array[$category->name] = $category->name;
        }
        
        return $array;
    }
    
    public function _getYears()
    {
        $mapper = new Model_Mapper_Post();
        $years = $mapper->fetchValidYears();
        
        $array[0] = 'All Years';
        
        for($year = $years['min_year']; $year <= $years['max_year']; $year++)
        {
            $array[$year] = $year;
        }
        
        return $array;
    }
}