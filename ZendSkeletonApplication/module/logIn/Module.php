<?php

namespace logIn;
 
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
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
    
    
     
    public function getServiceConfig()
    {
        return array(
            'factories'=>array(
                'AuthService' => function($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $dbTableAuthAdapter  = new DbTableAuthAdapter($dbAdapter, 
                                              'users','user_id','pass_word', 'MD5(?)');
             
                     $authService = new AuthenticationService();
                    $authService->setAdapter($dbTableAuthAdapter);
              
                    return $authService;
                    
                },
            ),
        );
    }
 
}