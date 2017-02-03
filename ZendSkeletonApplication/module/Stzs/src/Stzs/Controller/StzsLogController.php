<?php

namespace Stzs\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
 //use Stzs\Model\User ;
 //use Zend\Form\Annotation\AnnotationBuilder;
//use Zend\View\Model\ViewModel;
use Stzs\Form\LoginForm ;
use Stzs\Model\Login ;
 

 
class StzsLogController extends AbstractActionController
{
    protected $form;
   // protected $storage;
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
          //  $user      = new User();
          //  $builder    = new AnnotationBuilder();
          //  $this->form = $builder->createForm($user);
          $this->form = new LoginForm() ;
        }
         
        return $this->form;
    }
     
    public function loginAction()
    {
        //if already login, redirect to success page 
        if ($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('success2');
        }
                 
        $form    = $this->getForm();
         
        return array(
            'form'      => $form,
            'messages'  => $this->flashmessenger()->getMessages()
        );
    }
     
    public function authenticateAction()
    {
        $form       = $this->getForm();
        $redirect = 'login2';
        
        $request = $this->getRequest();
        if ($request->isPost()){
           
            $log = new Login();
            $form->setInputFilter($log->getInputFilter());
            
            $form->setData($request->getPost());
            
            if ( $form->isValid() ){
               
                //check authentication... // set identity and credentials using login form,
                $this->getAuthService()->getAdapter()
                                       ->setIdentity($request->getPost('username'))   
                                       ->setCredential($request->getPost('password')); 
                                        
                $result = $this->getAuthService()->authenticate();
               
                foreach($result->getMessages() as $message)
                {             
                    //save message temporary into flashmessenger
                    $this->flashmessenger()->addMessage($message);
                }
             
               if ($result->isValid()) {
                  
                    $redirect = 'success2';
                    
                } 
            }
        }
         
        return $this->redirect()->toRoute($redirect);
    }
     
    public function logoutAction()
    {        
        $this->getAuthService()->clearIdentity();
        
         
        $this->flashmessenger()->addMessage("You've been logged out");
        return $this->redirect()->toRoute('login2');
    }
}


