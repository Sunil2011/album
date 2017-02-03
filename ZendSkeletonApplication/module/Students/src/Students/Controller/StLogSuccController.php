<?php

namespace Students\Controller;
//session_start();
use Students\Model\Students;          // <-- Add this import
 use Students\Form\StudentsForm;       // <-- Add this import
 
 use Zend\Paginator\Paginator;
 use Zend\Paginator\Adapter\Iterator as paginatorIterator;
 use Zend\Db\Sql\Select ;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
 
class StLogSuccController extends AbstractActionController
{
    //protected $acl ;
    protected $studentsTable;
     public function getStudentsTable()
     {
         if (!$this->studentsTable) {
             $sm = $this->getServiceLocator();
             $this->studentsTable = $sm->get('Students\Model\StudentsTable');
         }
         return $this->studentsTable;
     }
     
    /* public function getAcl()
             {
         if(!$this->acl){
             $sm = $this->getServiceLocator();
             $this->acl = $sm->get('CreateAcl');
         }
         return $this->acl ;
     } */
         
     
    
  /*  public function indexAction()
    {
        if (! $this->getServiceLocator()
                 ->get('AuthService')->hasIdentity()){
            return $this->redirect()->toRoute('login1');
        }
         //return new ViewModel();
         else {
            // var_dump($this->albumTable);
             return new ViewModel(array(
                 'messages'  => $this->flashmessenger()->getMessages(),
             'students' => $this->getStudentsTable()->fetchAll(),  //---students
         ));
         }
    }*/
   
     # for pagination use below one
    
   /* public function indexAction()
     {
        if (! $this->getServiceLocator()
                 ->get('AuthService')->hasIdentity()){
            return $this->redirect()->toRoute('login1');
        }
        
        else{
            // grab the paginator from the AlbumTable
            $paginator = $this->getStudentsTable()->fetchAll(true);
            // set the current page to what has been passed in query string, or to 1 if none set
            $paginator->setCurrentPageNumber((int) $this->params()->fromQuery('page', 1));
            // set the number of items per page to 10
             $paginator->setItemCountPerPage(10);

            return new ViewModel(array(
                'messages'  => $this->flashmessenger()->getMessages(),
            'paginator' => $paginator
                    ));
        }
     
     }*/
    
    #for pagination and sorting use below one
     
     public function indexAction() {
         if (! $this->getServiceLocator()
                 ->get('AuthService1')->hasIdentity()){
            return $this->redirect()->toRoute('login1');
            
              }
         else{
             $select = new Select();

            $order_by = $this->params()->fromRoute('order_by') ?
                $this->params()->fromRoute('order_by') : 'id';
             
            $order = $this->params()->fromRoute('order') ?
                $this->params()->fromRoute('order') : Select::ORDER_ASCENDING;
            
            $page = $this->params()->fromRoute('page') ? (int) $this->params()->fromRoute('page') : 1;

            $students = $this->getStudentsTable()->fetchAll($select->order($order_by . ' ' . $order));
            $itemsPerPage = 4;

             $students->current();
             $paginator = new Paginator(new paginatorIterator($students));
             $paginator->setCurrentPageNumber($page)
                   ->setItemCountPerPage($itemsPerPage)
                    ->setPageRange(3);

              return new ViewModel(array(
                    'order_by' => $order_by,
                    'order' => $order,
                    'page' => $page,
                    'paginator' => $paginator,
                ));
            }
        }
     
     
     public function addAction()
     {
         if (! $this->getServiceLocator()
                 ->get('AuthService1')->hasIdentity()){
            return $this->redirect()->toRoute('login1');
        }
        else{
           
           // if($this->getAcl()->isAllowed($_SESSION['role'],'Auth','add')){
                $form2 = new StudentsForm();
                $form2->get('submit')->setValue('Add');
            
                $request = $this->getRequest();
            
                if ($request->isPost()) {
                    $student = new Students();
                    $form2->setInputFilter($student->getInputFilter());
                    $form2->setData($request->getPost());
                
                    if ($form2->isValid()) {
                        $student->exchangeArray($form2->getData());
                        //var_dump($album);
                        $this->getStudentsTable()->saveStudents($student);

                        // Redirect to list of albums
                        return $this->redirect()->toRoute('success1');
                    
                    }
                
                }
                return array('form2' => $form2);
          //  }
         /* else{
              $this->flashmessenger()->addMessage("You are not allowed to add ");
              return $this->redirect()->toRoute('success');
            }*/
        }
     }
     
     public function editAction()
     {
         if (! $this->getServiceLocator()
                 ->get('AuthService1')->hasIdentity()){
            return $this->redirect()->toRoute('login1');
        }
        else{
           
            //if($this->getAcl()->isAllowed($_SESSION['role'],'Auth','add')){
                $id = (int) $this->params()->fromPost('id', 0);
                $routeId = (int) $this->params()->fromRoute('id', 0);
                if (!$id && !$routeId) {
                    return $this->redirect()->toRoute('success1', array(
                    'action' => 'add'
                        ));
                }   
            
                if ($routeId) {
                $id = $routeId;
                 }

         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
                 try {
                     $student = $this->getStudentsTable()->getStudents($id);
                      //print_r($album); //fine
                    }
                  catch (\Exception $ex) {
                      return $this->redirect()->toRoute('success1', array(
                      'action' => 'index'
                     ));
                    }

                $form2  = new StudentsForm();
                $form2->bind($student);
                //print_r($form2);
                 $form2->get('submit')->setAttribute('value', 'Edit');

                $request = $this->getRequest();
                 //var_dump($request);
                  //var_dump($request->isPost()); // here is some problm
         
                 if ($request->isPost()) {
                   // var_dump($request->isPost());
             
                     $form2->setInputFilter($student->getInputFilter());
                     $form2->setData($request->getPost());

                      if ($form2->isValid()) {
                          $this->getStudentsTable()->saveStudents($student);

                          // Redirect to list of albums
                          return $this->redirect()->toRoute('success1');
                        }
                    }  /*else {
                          echo 'hello';
                            var_dump($request->isPost());    
                           }*/

                   return array(
                       'id' => $id,
                         'form2' => $form2,
                       );
           // }
           /* else{
                 $this->flashmessenger()->addMessage("You are not allowed to edit ");
                 return $this->redirect()->toRoute('success');
            }*/
       }
     }
     
     
      public function deleteAction()
        {
          if (! $this->getServiceLocator()
                 ->get('AuthService1')->hasIdentity()){
            return $this->redirect()->toRoute('login1');
            }
          else{
              
              //if($this->getAcl()->isAllowed($_SESSION['role'],'Auth','add')){
                  $id = (int) $this->params()->fromRoute('id', 0);
                 // var_dump($id); //correct
                  $PId = (int) $this->params()->fromPost('id',0);
              
                   if($PId){
                     $id = $PId ;
                    }
                   if (!$id) {
                     return $this->redirect()->toRoute('success1');
               
                    } 

                    $request = $this->getRequest();//here is some prblm
                    // var_dump($request->isPost());
                    if ($request->isPost()) {
                      $del = $request->getPost('del', 'No');
                        
                       if ($del == 'Yes') {
                        //var_dump($del);
                           $id = (int) $request->getPost('id');
                        // var_dump($id); 
                           $this->getStudentsTable()->deleteStudents($id);
                        }

                   // Redirect to list of students
                     return $this->redirect()->toRoute('success1');
                    }  

                    return array(
                      'id'    => $id,
                       'student' => $this->getStudentsTable()->getStudents($id)
                     );
               // }
               /* else{
                    $this->flashmessenger()->addMessage("You are not allowed to delete");
                    return $this->redirect()->toRoute('success');
                }*/
            }
        }
    
    
}