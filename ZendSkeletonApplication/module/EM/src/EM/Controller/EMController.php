<?php
namespace EM\Controller;

use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;

use EM\Model\EM ;
/*
use Zend\EventManager\EventManagerInterface;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerAwareInterface;
 */
 
class EMController extends AbstractActionController
 {
    public function indexAction (){
        
        $foo = new EM() ;
        // attaching events to the new object 
        $foo->getEventManager()->attach('bar', function($e){
            $event  = $e->getName();
            $target = get_class($e->getTarget());
            $params = json_encode($e->getParams());
           // var_dump(123);
           // exit;
           echo " *** ";
            printf(
                    '%s called on %s , using parameters %s ',
                    $event ,
                    $target,
                    $params
                    );
                    
            echo ' !!***!! ';
          
        }
        );

$foo->bar("Baz","Bat");

    }
    
}

