<?php

namespace Auth\Controller;
session_start();
use Auth\Model\Album;          // <-- Add this import
 use Auth\Form\AlbumForm;       // <-- Add this import
 
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
 
class SuccessController extends AbstractActionController
{
    protected $acl ;
    protected $albumTable;
     public function getAlbumTable()
     {
         if (!$this->albumTable) {
             $sm = $this->getServiceLocator();
             $this->albumTable = $sm->get('Auth\Model\AlbumTable');
         }
         return $this->albumTable;
     }
     
     public function getAcl()
             {
         if(!$this->acl){
             $sm = $this->getServiceLocator();
             $this->acl = $sm->get('CreateAcl');
         }
         return $this->acl ;
     }
         
     
    
    public function indexAction()
    {
        if (! $this->getServiceLocator()
                 ->get('AuthService')->hasIdentity()){
            return $this->redirect()->toRoute('login');
        }
         //return new ViewModel();
         else {
            // var_dump($this->albumTable);
             return new ViewModel(array(
                 'messages'  => $this->flashmessenger()->getMessages(),
             'albums' => $this->getAlbumTable()->fetchAll(),
         ));
         }
    }
    
     public function addAction()
     {
         if (! $this->getServiceLocator()
                 ->get('AuthService')->hasIdentity()){
            return $this->redirect()->toRoute('login');
        }
        else{
           // if($_SESSION['role']== 'Admin'){
            if($this->getAcl()->isAllowed($_SESSION['role'],'Auth','add')){
                $form2 = new AlbumForm();
                $form2->get('submit')->setValue('Add');
            
                $request = $this->getRequest();
            
                if ($request->isPost()) {
                    $album = new Album();
                    $form2->setInputFilter($album->getInputFilter());
                    $form2->setData($request->getPost());
                
                    if ($form2->isValid()) {
                        $album->exchangeArray($form2->getData());
                        //var_dump($album);
                        $this->getAlbumTable()->saveAlbum($album);

                        // Redirect to list of albums
                        return $this->redirect()->toRoute('success');
                    
                    }
                
                }
                return array('form2' => $form2);
            }
          else{
              $this->flashmessenger()->addMessage("You are not allowed to add ");
              return $this->redirect()->toRoute('success');
            }
        }
     }
     
     public function editAction()
     {
         if (! $this->getServiceLocator()
                 ->get('AuthService')->hasIdentity()){
            return $this->redirect()->toRoute('login');
        }
        else{
           // if($_SESSION['role']=='Admin'){
            if($this->getAcl()->isAllowed($_SESSION['role'],'Auth','add')){
                $id = (int) $this->params()->fromPost('id', 0);
                $routeId = (int) $this->params()->fromRoute('id', 0);
                if (!$id && !$routeId) {
                    return $this->redirect()->toRoute('success', array(
                    'action' => 'add'
                        ));
                }   
            
                if ($routeId) {
                $id = $routeId;
                 }

         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
                 try {
                     $album = $this->getAlbumTable()->getAlbum($id);
                      //print_r($album); //fine
                    }
                  catch (\Exception $ex) {
                      return $this->redirect()->toRoute('success', array(
                      'action' => 'index'
                     ));
                    }

                $form2  = new AlbumForm();
                $form2->bind($album);
                //print_r($form2);
                 $form2->get('submit')->setAttribute('value', 'Edit');

                $request = $this->getRequest();
                 //var_dump($request);
                  //var_dump($request->isPost()); // here is some problm
         
                 if ($request->isPost()) {
                   // var_dump($request->isPost());
             
                     $form2->setInputFilter($album->getInputFilter());
                     $form2->setData($request->getPost());

                      if ($form2->isValid()) {
                          $this->getAlbumTable()->saveAlbum($album);

                          // Redirect to list of albums
                          return $this->redirect()->toRoute('success');
                        }
                    }  /*else {
                          echo 'hello';
                            var_dump($request->isPost());    
                           }*/

                   return array(
                       'id' => $id,
                         'form2' => $form2,
                       );
            }
            else{
                 $this->flashmessenger()->addMessage("You are not allowed to edit ");
                 return $this->redirect()->toRoute('success');
            }
       }
     }
     
     
      public function deleteAction()
        {
          if (! $this->getServiceLocator()
                 ->get('AuthService')->hasIdentity()){
            return $this->redirect()->toRoute('login');
            }
          else{
              //if($_SESSION['role']== 'Admin'){
              if($this->getAcl()->isAllowed($_SESSION['role'],'Auth','add')){
                  $id = (int) $this->params()->fromRoute('id', 0);
                 // var_dump($id); //correct
                  $PId = (int) $this->params()->fromPost('id',0);
              
                   if($PId){
                     $id = $PId ;
                    }
                   if (!$id) {
                     return $this->redirect()->toRoute('success');
               
                    } 

                    $request = $this->getRequest();//here is some prblm
                    // var_dump($request->isPost());
                    if ($request->isPost()) {
                      $del = $request->getPost('del', 'No');
                        
                       if ($del == 'Yes') {
                        //var_dump($del);
                           $id = (int) $request->getPost('id');
                        // var_dump($id); 
                           $this->getAlbumTable()->deleteAlbum($id);
                        }

                   // Redirect to list of albums
                     return $this->redirect()->toRoute('success');
                    }  /*else {
                       var_dump(123);    
                      }*/

                    return array(
                      'id'    => $id,
                       'album' => $this->getAlbumTable()->getAlbum($id)
                     );
                }
                else{
                    $this->flashmessenger()->addMessage("You are not allowed to delete");
                    return $this->redirect()->toRoute('success');
                }
            }
        }
    
    
}