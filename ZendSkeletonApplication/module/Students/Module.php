<?php

namespace Students ;

 
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

 use Students\Model\Students;
 use Students\Model\StudentsTable;

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
                'AuthService1' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 
                                              'students','userName','password');
                    //here userName is identity and password is credential 
             
                     $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
              
                    return $authService;
                    
                },
                  
                 'Students\Model\StudentsTable' =>  function($sm) {
                    $tableGateway = $sm->get('StudentsTableGateway');
                    $table = new StudentsTable($tableGateway);
                     return $table;
                    },
                         
                 'StudentsTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Students());
                     return new TableGateway('studentsTable', $dbAdapter, null, $resultSetPrototype);
                   // here studentsTable is data table name it could be any name
                     },
            )
        );
        
    }
    
}
    
    