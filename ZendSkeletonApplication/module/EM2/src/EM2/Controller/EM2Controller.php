<?php

namespace EM2\Controller;

use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;
use Zend\EventManager\SharedEventManager;

use EM2\Model\EM2 ;

 
class EM2Controller extends AbstractActionController
 {
    public function indexAction (){
        $sharedEvent = new SharedEventManager();
        //var_dump($events);
        
        $sharedEvent->attach('EM2', 'bar', function ($e) {
        $event  = $e->getName();
        //var_dump($event);
        $target = get_class($e->getTarget());
        $params = json_encode($e->getParams());
        echo ' *** ';
        printf(
                '%s called on %s, using params %s',
                $event,
                $target,
                $params
                );
        echo '!***!';
        
        });
        
        $foo = new EM2();
        $foo->getEventManager()->setSharedManager($sharedEvent);
        
        
        //echo '12345';
       
        //print_r($foo);
       
        $foo->bar("ABC", "XYZ");      

}
    
}