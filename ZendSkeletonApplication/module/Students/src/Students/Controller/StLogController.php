<?php

namespace Students\Controller;
//session_start();
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Form\Annotation\AnnotationBuilder;
//use Zend\View\Model\ViewModel;
 
use Students\Model\User ;
 
class StLogController extends AbstractActionController
{
    protected $form;
   // protected $storage;
    protected $authservice;
   


    public function getAuthService()
    {
        if (! $this->authservice) {
            $this->authservice = $this->getServiceLocator()
                                      ->get('AuthService1');
        }
         
        return $this->authservice;
    }
     
     
    public function getForm()
    {
        if (! $this->form) {
            $user      = new User();
            $builder    = new AnnotationBuilder();
            $this->form = $builder->createForm($user);
        }
         
        return $this->form;
    }
     
    public function loginAction()
    {
        //if already login, redirect to success page 
        if ($this->getAuthService()->hasIdentity()){
            return $this->redirect()->toRoute('success1');
        }
                 
        $form       = $this->getForm();
         
        return array(
            'form'      => $form,
            'messages'  => $this->flashmessenger()->getMessages()
        );
    }
     
    public function authenticateAction()
    {
        $form       = $this->getForm();
        $redirect = 'login1';
         
        $request = $this->getRequest();
        if ($request->isPost()){
            $form->setData($request->getPost());
            if ($form->isValid()){
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
                  
                    $redirect = 'success1';
                  
                   
                   // $this->getAuthService()->getStorage()->write($request->getPost('username'));
                    //$rowResult = $this->getAuthService()->getAdapter()->getResultRowObject();
                  //  $_SESSION['role'] = $rowResult->role;
                } 
            }
        }
         
        return $this->redirect()->toRoute($redirect);
    }
     
    public function logoutAction()
    {        
        $this->getAuthService()->clearIdentity();
        
       // session_destroy();
         
        $this->flashmessenger()->addMessage("You've been logged out");
        return $this->redirect()->toRoute('login1');
    }
}


