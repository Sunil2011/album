<?php

namespace jQuery\Controller ;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class jQueryController extends AbstractActionController
 {
    public function indexAction(){
        
        echo '******';
        $message = "jQuery Example : ";
        return new ViewModel( array('message' => $message) ) ;
       // or  return  new ViewModel();
     
    }
}

