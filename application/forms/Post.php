<?php

class Form_Post extends Keplin_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post')->setName('post_form');
        
        $this->addElement('text', 'title', array(
            'label' => 'Title',
            'style' => 'width: 400px;',
            'required' => true 
        ));
        
        $this->addElement('textarea', 'content', array(
            'label' => 'Content',
            'attribs' => array(
                'class' => 'content-input'
            ),
            'required' => true 
        ));
        
        $this->addElement('select', 'category_id', array(
            'label' => 'Category',
            'multioptions' => $this->_getCategories(),
            'required' => false
        ));
        
        $this->addElement('text', 'new_category', array(
            'label' => 'New Category',
            'required' => false 
        ));
        
        $this->addElement('select', 'is_published', array(
            'label' => 'Published',
            'multioptions' => array('0' => 'No', '1' => 'Yes'),
            'required' => true
        ));
        
        $this->addElement('submit', 'submit_post', array(
            'label' => 'Create Post'
        ));
    }
    
    public function setSubmitLabel($label)
    {
        $this->submit_post->setLabel($label);
    }
    
    protected function _getCategories()
    {
        $mapper = new Model_Mapper_Category();
        $categories = $mapper->fetchAll(0);
        
        foreach($categories as $category)
        {
            $array[$category->id] = $category->name;
        }
        
        return $array;
    }
}