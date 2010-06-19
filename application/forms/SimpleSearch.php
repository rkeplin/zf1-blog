<?php

class Form_SimpleSearch extends Keplin_Form_Abstract
{
    public function init()
    {
        $this->setMethod('get')
             ->setAction('/blog/search-handler/')
             ->setName('searchform');
        
        $this->setDecorators(array(
            array('ViewScript', array('viewScript' => 'simple-search-form.phtml')))
        );
        
        $this->addElement('text', 'query', array(
            'label' => 'Search',
            'required' => false 
        ));
        
        $this->query->setDecorators(array(
            'ViewHelper',
            array('HtmlTag', array('tag' => 'p'))
        ));
    }
}