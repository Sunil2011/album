<?php

namespace Stzs ;

 
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

 use Stzs\Model\Stzs;
 use Stzs\Model\StzsTable;

 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;

//use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;


 
class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig(){
        return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
        
    }
    
    
    public function getConfig(){ 
        
         return include __DIR__ . '/config/module.config.php';
    }
    
    
    public function getServiceConfig(){
        
        return array(
            'factories'=> array(
                'AuthService2' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 
                                              'stzs','userName','password');
                    //here userName is identity and password is credential 
             
                    $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
              
                    return $authService;
                    
                },
                  
                 'Stzs\Model\StzsTable' =>  function($sm) {
                    $tableGateway = $sm->get('StzsTableGateway');
                    $table = new StzsTable($tableGateway);
                     return $table;
                    },
                         
                 'StzsTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Stzs());
                     return new TableGateway('stzsTable', $dbAdapter, null, $resultSetPrototype);
                   // here studentsTable is data table name it could be any name
                     },
            )
        );
        
    }
    
}
    
    