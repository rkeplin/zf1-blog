<?php
require_once 'Zend/Test/PHPUnit/ControllerTestCase.php';

abstract class ControllerTestCase extends Zend_Test_PHPUnit_ControllerTestCase
{
    /**
     * $var Zend_Application
     **/
    protected $application;
    
    public function setUp()
    {
        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
        Zend_Auth::getInstance()->setStorage(new Zend_Auth_Storage_NonPersistent());
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
    }
    
    public function tearDown()
    {
        Zend_Auth::getInstance()->clearIdentity();
    }
    
    public function appBootstrap()
    {
        $this->application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->application->bootstrap();
    }
}