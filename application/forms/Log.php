<?php

class Form_Log extends Keplin_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post')->setName('log_form');
        
        $this->addElement('submit', 'login', array(
            'label' => 'Delete Log'
        ));
    }
}