<?php

namespace AlbumRest\Controller;
 
use Zend\Mvc\Controller\AbstractRestfulController;
 
use Album\Model\Album;
use Album\Form\AlbumForm;
//use Album\Model\AlbumTable;
use Zend\View\Model\JsonModel;
 
class AlbumRestController extends AbstractRestfulController
{
   protected $albumTable;
    public function getList()
    {
        # code...
        $results = $this->getAlbumTable()->fetchAll();
        $data = array();
        foreach($results as $result) {
             $data[] = $result;
        }
 
       //return array('data' => $data); // earlier one
       return new JsonModel(array(
           'data' => $data,
         ));
        
    }
 
    public function get($id)
    {
        # code...
         $album = $this->getAlbumTable()->getAlbum($id);//earlier one
         
       // return array("data" => $album);  //earlier one 
       
          return new JsonModel(array(
           'data' => $album,
         ));
        
    }
 
    public function create($data)
    {
        # code...
        // var_dump($data);exit;
        $form = new AlbumForm();
        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
       
       // var_dump($form->isValid()); exit;// problem is here returning bool(false) so not executing ...
        //above problem solved change in Album\Model\Album.php 
        //set change in inputfilter for id set required=false 
       
        if ($form->isValid()) {
            $album->exchangeArray($form->getData());
            $id = $this->getAlbumTable()->saveAlbum($album);
        
            // var_dump($id); exit; 
        }
 
        /*return new JsonModel(array(  //earlier one
           'data' => $this->getAlbumTable()->getAlbum($id)
         ));*/
        
         //var_dump($id); exit; // problem is here returning null 
         return ($this->get($id));
       
       
    }
 
    public function update($id, $data)
    {
        # code...
        $data['id'] = $id;

        $album = $this->getAlbumTable()->getAlbum(intval($id));
        $form  = new \Album\Form\AlbumForm();
        $form->bind($album);
        $form->setInputFilter($album->getInputFilter());
        $form->setData($data);
        
        if ($form->isValid()) {
            $id = $this->getAlbumTable()->saveAlbum($form->getData());
        }else{
            return new JsonModel(array('msg'=>'not updated !'));
        }
        /*
         return new JsonModel(array(     // earlier one 
            'data' => $this->get($id),
          ));
       */
         return (
             $this->get($id)
          );
        
        
    }
 
    public function delete($id)
    {
        # code...
        $this->getAlbumTable()->deleteAlbum($id);
 
        return new JsonModel(array(
            'data' => 'deleted',
         ));
        
    }
    
    public function getAlbumTable()
    {
        if (!$this->albumTable) {
        $sm = $this->getServiceLocator();
        $this->albumTable = $sm->get('Album\Model\AlbumTable');
        
        }
        return $this->albumTable;
        
    }
}

