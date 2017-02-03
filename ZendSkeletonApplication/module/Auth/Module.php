<?php

namespace Auth;
 
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

 use Auth\Model\Album;
 use Auth\Model\AlbumTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;

//use Zend\Authentication\Storage;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;

// for ACL 
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole as Role;
use Zend\Permissions\Acl\Resource\GenericResource as Resource;

 
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
                  
                 'Auth\Model\AlbumTable' =>  function($sm) {
                    $tableGateway = $sm->get('AlbumTableGateway');
                    $table = new AlbumTable($tableGateway);
                     return $table;
                    },
                         
                 'AlbumTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Album());
                     return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                    },
                            
                   'CreateAcl' => function(){
                       
                        $acl = new Acl();
                        $acl->deny();
                        
                        
                        $acl->addRole(new Role('User'));
                        $acl->addRole(new Role('Admin'),'User');
                        $acl->addResource(new Resource('Auth'));
                        
                        
                       // $acl->allow('User','Auth','index');
                       // $acl->allow('Admin','Auth', array('add','edit','delete'));
                        $acl->allow('User','Auth','index');
                        $acl->allow('Admin','Auth','add');
                        $acl->allow('Admin','Auth','edit');
                        $acl->allow('Admin','Auth','delete');
                        
                        
                        return $acl ;
                   }         
                        
            ),
        );
    }
 
}

