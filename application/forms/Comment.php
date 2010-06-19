<?php

class Form_Comment extends Keplin_Form_Abstract
{
    public function init()
    {
        $this->setMethod('post')->setName('comment_form');
        
        $this->addElement('select', 'parent_id', array(
            'label' => 'Reply To',
            'multioptions' => array(),
            'required' => false
        ));
        
        $this->addElement('text', 'name', array(
            'label' => 'Name',
            'required' => true 
        ));
        
        $this->addElement('text', 'email', array(
            'label' => 'Email (will not be published)',
            'required' => true 
        ));
        $this->email->addValidator('EmailAddress');
        
        $this->addElement('text', 'website', array(
            'label' => 'Website',
            'required' => false,
            'invalidMessage' => 'wtf'
        ));
        $this->website->addValidator('Regex', false, array('pattern' => '/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/', 'messages' => array('regexNotMatch' => 'This website is invalid. Make sure you include the http://')));
        
        $this->addElement('textarea', 'comment', array(
            'label' => 'Comment',
            'attribs' => array(
                'rows' => 5,
                'cols' => 70
            ),
            'required' => true 
        ));
        
        if(APPLICATION_ENV != 'testing')
        {
            $this->addElement('captcha', 'captcha', array(
                'label' => '',
                'captcha' => array(
                    'captcha' => 'dumb',
                    'wordLen' => 4
                )
            ));   
        }
        
        $this->addElement('submit', 'submit_comment', array(
            'label' => 'Submit Comment'
        ));
    }
    
    public function setComments($post_id)
    {
        $mapper = new Model_Mapper_Comment();
        $comments = $mapper->getPostComments($post_id);
        
        $array[0] = 'Select a comment...';
        
        foreach($comments as $comment)
        {
            $array[$comment->id] = substr($comment->name, 0, 25) . ': ' . strip_tags(substr($comment->comment, 0, 25)) . '...';
        }
        
        $this->parent_id->setMultiOptions($array);
    }
}