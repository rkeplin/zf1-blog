<?php
class ErrorController extends Zend_Controller_Action
{
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
        
        $logger = new Zend_Log();
        $writer = new Zend_Log_Writer_Stream(dirname(APPLICATION_PATH) . '/logs/exceptions.log');
        $logger->addWriter($writer);
        //$logger->addWriter(new Keplin_Log_Writer_Email());
        
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
        
                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->message = 'Page not found';
                
                $logger->log($errors->exception->getMessage(), Zend_Log::NOTICE);
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'Application error';
                
                if(get_class($errors->exception) == 'Keplin_ProhibitedException') {
                    $this->view->message = 'Access Prohibited.';
                    $logger->log($errors->exception->getMessage(), Zend_Log::WARN);
                } else {
                    $logger->log($errors->exception->getMessage(), Zend_Log::ERR);
                }
                
                break;
        }
        
        // conditionally display exceptions
        if ($this->getInvokeArg('displayExceptions') == true) {
            $this->view->exception = $errors->exception;
        }
        
        $this->view->request   = $errors->request;
    }
}
