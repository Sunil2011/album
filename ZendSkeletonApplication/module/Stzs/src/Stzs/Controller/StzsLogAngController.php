<?php

namespace Stzs\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;

use Stzs\Form\LoginForm ;
use Stzs\Model\Login ;
 
use Zend\View\Model\JsonModel;
 
class StzsLogAngController extends AbstractActionController
{
    protected $form;

    protected $authservice;
   


    public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService2');
        }
         
        return $this->authservice;
    }
     
     
    public function getForm()
    {
        if (! $this->form) {
        
          $this->form = new LoginForm() ;
        }
         
        return $this->form;
    }
   
    /*
    public function loginAction()
    {
        //if already login, redirect to success page 
        if ($this->getAuthService()->hasIdentity()){
            return new JsonModel(array(
                'msg' => 'authenticated'
            ));
        }
                 
        $form = $this->getForm();
         
        return new JsonModel(array(
            
        ));
    }
    */ 
    
    public function authenticateAction()
    {
        $form       = $this->getForm();
        
        $request = $this->getRequest();
       
        if ($request->isPost()){
           
            $log = new Login();
            $form->setInputFilter($log->getInputFilter());
            
            # get data from angular http request
            $data = json_decode(file_get_contents("php://input"),TRUE) ;
            
           // $form->setData($request->getPost());
            $form->setData($data);
            
            if ( $form->isValid() ){
               
                //check authentication... // set identity and credentials using login form,
                $this->getAuthService()->getAdapter()
                                       ->setIdentity($data['username'])   
                                       ->setCredential($data['password']); 
                                        
                $result = $this->getAuthService()->authenticate();
               
                $authMsg = array();
                foreach($result->getMessages() as $message)
                {             
                    //save message temporary into flashmessenger
                    //$this->flashmessenger()->addMessage($message);
                    $authMsg[] = $message ;
                }
             
               if ($result->isValid()) {
                  
                   return new JsonModel(array(
                       'msg' => 'authenticated',
                       'authMsg' => ''
                       
                   )) ;
                    
                }else{
                   return new JsonModel(array(
                       'authMsg' => $authMsg  
                   )); 
                } 
                
            }
        }
         
        return new JsonModel(array(
            'msg' => 'no post data for authentication ..'
        ));
    }
     
    public function logoutAction()
    {        
        $this->getAuthService()->clearIdentity();
        
        return new JsonModel(array(
            'msg' => "You've been log out "
        )) ;
    }
}





