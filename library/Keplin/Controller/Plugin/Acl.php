<?php
class Keplin_Controller_Plugin_Acl extends Zend_Controller_Plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {
        $acl = new Zend_Acl();
        $acl->addRole(new Zend_Acl_Role(Model_Role::GUEST));
        $acl->addRole(new Zend_Acl_Role(Model_Role::ADMIN), Model_Role::GUEST);
        
        $acl->addResource(new Zend_Acl_Resource('admin'));
        $acl->addResource(new Zend_Acl_Resource('blog'));
        $acl->addResource(new Zend_Acl_Resource('error'));
        $acl->addResource(new Zend_Acl_Resource('index'));
        
        $acl->allow(Model_Role::GUEST, 'blog');
        $acl->allow(Model_Role::GUEST, 'error');
        $acl->allow(Model_Role::GUEST, 'index');
        $acl->allow(Model_Role::GUEST, 'admin', array('login'));
        
        $acl->allow(Model_Role::ADMIN, 'admin');
        
        $auth = Zend_Auth::getInstance();
        
        if($auth->hasIdentity())
        {
            $user = new Model_User($auth->getIdentity());
            $role = $user->role_id;
        }
        else
        {
            $role = Model_Role::GUEST;
        }
        
        $resource = $request->getControllerName();
        $privilege = $request->getActionName();
         
        if(!$acl->isAllowed($role, $resource, $privilege))
        {
            $this->_request->setControllerName('admin')->setActionName('login');
            $this->_response->setRedirect('/admin/login/');
        }
    }
}