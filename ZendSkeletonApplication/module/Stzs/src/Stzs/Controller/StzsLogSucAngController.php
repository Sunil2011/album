<?php

namespace Stzs\Controller;

use Stzs\Model\Stzs;          // <-- Add this import
use Stzs\Form\StzsForm;       // <-- Add this import
 
 
use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class StzsLogSucAngController extends AbstractActionController
{
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
        $res = $this->getStzsTable()->fetchAll();
        
        $a_res = array();
        
        foreach ($res as $r){
            $a_res['id'] = $r->id  ;  
            $a_res['name']  = $r->name;
            $a_res['department'] = $r->department;
            $a[] = $a_res;  // creating multi. dim. array by adding all
                 
        }
        
        return new JsonModel(array(
            'stzs' => $a,
           // 'msg' => array('name'=>'sunil','lname'=>'kumar')
        ));
        
    }
    
    
    public function addAction()
    {
        $form2 = new StzsForm();
        $form2->get('submit')->setValue('Add');
        
        $request = $this->getRequest();
       
        if ( $request->isPost() ){
           
            # get data from angular http request
            $data = json_decode(file_get_contents("php://input"),TRUE) ;
        
            
            $stz = new Stzs();
           
            $form2->setInputFilter($stz->getInputFilter());
            
           
            $form2->setData($data);
            
            
            if ($form2->isValid()) {
                $stz->exchangeArray($form2->getData());
                        
                $this->getStzsTable()->saveStzs($stz);
               
                
                $st = $stz->name ;
                $dp = $stz->department ;
                $msg = 'Student : '.$st.' with Department : '.$dp.' is added successfully ! '  ;
                return new JsonModel(array(
                    'msg' => $msg ,
                )) ;
                
              
                
           }  else {
               return new JsonModel(array(
                    'msg' => 'validation failed !' ,
                )) ;
           }
                
                
        }
        
        return new JsonModel(array(
            'msg' => 'data is not posted !' ,
        ));
        
    }
    
    
    public function dataToEditOrDeleteAction()
    {
        $routeId =  $this->params()->fromRoute('id', 0); // from route
       
        if($routeId){
            try {
                $stz = $this->getStzsTable()->getStzs($routeId);
            }
            catch (\Exception $ex) {
                return new JsonModel(array(
                  'msg' => 'data with given id is not present in db !' 
                )) ;
            }
         
            return new JsonModel(array(
             'stz' => $stz 
            )) ;
            
        }else{
            return new JsonModel(array(
             'msg' => 'there is no data with id 0 !' 
            )) ;
        }
        
        
    }
    
    public function updateAction()
    {
        
        $form2 = new StzsForm();
        $form2->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        $routeId =  $this->params()->fromRoute('id', 0);
        
        if(!$routeId){
            return new JsonModel(array(
                'msg'=> 'no data with given id ( 0 ) ',
            ));
        }
        
        $stz = $this->getStzsTable()->getStzs($routeId);
        
        if( $request->isPost() ){
            
            $data = json_decode(file_get_contents("php://input"),TRUE) ;
           // $id = $data['id'];
           /*
            if($routeId){
                $id = $routeId ;
            }
            */
            $form2->setInputFilter($stz->getInputFilter());
            
            $form2->setData($data) ;
            
            if($form2->isValid()){
                $stz->exchangeArray($form2->getData());
                
                $this->getStzsTable()->saveStzs($stz);
                
                $st = $stz->name ;
                $dp = $stz->department ;
                $msg = 'Student : '.$st.' with Department : '.$dp.' is updated successfully ! '  ;
                return new JsonModel(array(
                    'msg' => $msg ,
                )) ;
                
            }else{
                return new JsonModel(array(
                    'msg' => 'validation failed !' ,
                )) ;
            }
            
        }
        
        return new JsonModel(array(
            'msg' => 'data is not posted !' ,
        ));
        
    }
    
    
    
    public function deleteAction()
    {
        $routeId = (int) $this->params()->fromRoute('id', 0);
        $request = $this->getRequest();
       
        if(!$routeId){
            return new JsonModel(array(
                'msg'=> 'no data with given id ( 0 ) ',
            ));
        }
        
        if($request->isPost()){
            $data = json_decode(file_get_contents("php://input"),TRUE) ;
            
            if($data['del'] == 'Yes' ){
                $id = $data['id'];
                $this->getStzsTable()->deleteStzs($id);
                
                return new JsonModel(array(
                    'msg' => 'data with id ' .$id . ' is deleted !'
                ));
                
            }else{
                return new JsonModel(array(
                    'msg' => 'data to delete is cancelled '
                ));
            }
            
        }else{
            return new JsonModel(array(
                'msg' => 'data to delete is not confirmed '
            ));
        }
        
    }
    
}
