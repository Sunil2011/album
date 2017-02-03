<?php

namespace Stzs\Controller;

use Stzs\Model\Stzs;          // <-- Add this import
use Stzs\Form\StzsForm;       // <-- Add this import
 

use Zend\Db\Sql\Select ;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

 
class StzsLogSucController extends AbstractActionController
{
    //protected $acl ;
    protected $stzsTable;

   
    public function getStzsTable()
    {
        if (!$this->stzsTable) {
            $sm = $this->getServiceLocator();
            $this->stzsTable = $sm->get('Stzs\Model\StzsTable');
        }
        return $this->stzsTable;
    }
     
     
    
   public function indexAction()
    {
        if (! $this->getServiceLocator()
                 ->get('AuthService2')->hasIdentity()){
            return $this->redirect()->toRoute('login2');
        }
         
        else {
            return new ViewModel(array(
                'messages'  => $this->flashmessenger()->getMessages(),
            // 'stzs' => $this->getStzsTable()->fetchAll(),  //---students
            ));
        }
                 
    }
   

    
     
    public function addAction()
    {
        if (! $this->getServiceLocator()
                 ->get('AuthService2')->hasIdentity()){
            return $this->redirect()->toRoute('login2');
        }
        else{
           
           
            $form2 = new StzsForm();
            $form2->get('submit')->setValue('Add');
            
            $request = $this->getRequest();
            
            if ($request->isPost()) {
                $stz = new Stzs();
                
               // var_dump($request->getPost()); exit ;
               // var_dump($request->getPost()->toArray()); exit;
                
                $form2->setInputFilter($stz->getInputFilter());
                $form2->setData($request->getPost());
                
                if ($form2->isValid()) {
                    $stz->exchangeArray($form2->getData());
                    
                    //var_dump($stz->name); exit;
                    $this->getStzsTable()->saveStzs($stz);

                     // Redirect to list of albums
                    return $this->redirect()->toRoute('success2');
                    
                }
                
            }
            return array('form2' => $form2);
          
        }
    }
     
    public function editAction()
    {
        if (! $this->getServiceLocator()
                 ->get('AuthService2')->hasIdentity()){
            return $this->redirect()->toRoute('login2');
        }
        else{
           
            $id = (int) $this->params()->fromPost('id', 0);
            $routeId = (int) $this->params()->fromRoute('id', 0);
            if (!$id && !$routeId) {
                return $this->redirect()->toRoute('success2', array(
                   'action' => 'add'
                ));
            }   
            
            if ($routeId) {
                $id = $routeId;
            }

         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
            try {
                $stz = $this->getStzsTable()->getStzs($id);
            }
            catch (\Exception $ex) {
                return $this->redirect()->toRoute('success2', array(
                'action' => 'index'
                ));
            }

            $form2  = new StzsForm();
            $form2->bind($stz);
               
            $form2->get('submit')->setAttribute('value', 'Edit'); 
                 // here form attribute value go is being reset to Edit

            $request = $this->getRequest();
                 
            if ($request->isPost()) {
                // var_dump($request->isPost());
             
                $form2->setInputFilter($stz->getInputFilter());
                $form2->setData($request->getPost());

                if ($form2->isValid()) {
                    $this->getStzsTable()->saveStzs($stz);

                    // Redirect to list of albums
                    return $this->redirect()->toRoute('success2');
                }
            }  
             
            return array(
                'id' => $id,
                'form2' => $form2,
            );
           
        }
    }
     
     
    public function deleteAction()
    {
        if (! $this->getServiceLocator()
                ->get('AuthService2')->hasIdentity()){
            return $this->redirect()->toRoute('login2');
        }
        else{
              
            $id = (int) $this->params()->fromRoute('id', 0);
           
            $PId = (int) $this->params()->fromPost('id',0);
              
            if($PId){
                $id = $PId ;
            }
            if (!$id) {
                return $this->redirect()->toRoute('success2');
               
            } 

            $request = $this->getRequest();
                    
            if ($request->isPost()) {
               // var_dump($PId); exit;
                $del = $request->getPost('del', 'No');
                     
                if ($del == 'Yes') {
                    //var_dump($del);
                    $id = (int) $request->getPost('id');
                    // var_dump($id); 
                    $this->getStzsTable()->deleteStzs($id);
                }

                // Redirect to list of students
                return $this->redirect()->toRoute('success2');
            }  

            return array(
               'id'    => $id,
                //'stz' => $this->getStzsTable()->getStzs($id)  // no need bcz using AngularJS 
            );

        }
    }
        
        
        
    public function getJsonAction(){
      //  if (! $this->getServiceLocator()
      //          ->get('AuthService2')->hasIdentity()){
      //     return $this->redirect()->toRoute('login2');
      //    
      //  }
       // else{
            $res = $this->getStzsTable()->fetchAll();
           // echo json_encode($res);exit;
            $a_res = array();
           
           //for JSON we have convert table in multi. dimensions array form
           
            foreach ($res as $r){
               $a_res['id'] = $r->id  ;  
               $a_res['name']  = $r->name;
               $a_res['department'] = $r->department;
               $a[] = $a_res; 
               // here i m not assining any key to a[] so is just adding the arrays
               
            }
           
           
            return new JsonModel(array(
                'stzs' => $a,  
            ));
       // }
    }
        
        
    public function getJsonToDeleteAction()
    {
      //  if (! $this->getServiceLocator()
      //          ->get('AuthService2')->hasIdentity()){
      //      return $this->redirect()->toRoute('login2');
      //    
      //  }
      //  else{
            $id = (int) $this->params()->fromRoute('id', 0);
            
                  
            $st = $this->getStzsTable()->getStzs($id);
           
            $d_res['id'] = $st->id;
            $d_res['name'] = $st->name;
            $d_res['department'] = $st->department;
              
            
            return new JsonModel(array(
               'stz' => $d_res ,
            ));
       // }
    }
        
    public function getJsonToEditAction(){
        
      //  if (! $this->getServiceLocator()
      //          ->get('AuthService2')->hasIdentity()){
      //      return $this->redirect()->toRoute('login2');
      //  }
      //  else{
           $id = (int) $this->params()->fromRoute('id', 0);
           
           $stz = $this->getStzsTable()->getStzs($id);
          
          // echo '<pre>';var_dump($stz);exit;
           return new JsonModel(array(
                'stz' => $stz,  
            ));
           
       // }
    }
    
}