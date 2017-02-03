<?php

namespace EM3\Controller;

use Zend\Mvc\Controller\AbstractActionController;
//use Zend\View\Model\ViewModel;
use Zend\EventManager\SharedEventManager;

use EM3a\Model\EM3a ;
use EM3b\Model\EM3b ;

class EM3Controller extends AbstractActionController
 {
    public function indexAction (){
        $events = new SharedEventManager();
        // events bar and bax will attach to the both class EM3a and EM3b .
        $events->attach(array('EM3a','Em3b'),array('bar','bax'),function ($e) {
        $event  = $e->getName();
        //var_dump($event);
        $target = get_class($e->getTarget());
        $params = json_encode($e->getParams());
        echo '=> ';
        printf(
                '... %s called on %s, using params %s !!',
                $event,
                $target,
                $params
                );
        
        echo '<br>';
        
        } );
        
        
        $foo1 = new EM3a();
        $foo2 = new EM3b();
        
        $foo1->getEventManager()->setSharedManager($events);
        $foo1->bar('ABC', 'XYZ');
        $foo1->bax('abc','xyz');
        
        $foo2->getEventManager()->setSharedManager($events);
        $foo2->bar('MNO', 'RST');
        $foo2->bax('mno', 'rst');
        
    }
 }