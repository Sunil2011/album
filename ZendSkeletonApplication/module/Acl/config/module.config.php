<?php

namespace Acl;

return array(
    
    'controllers' => array(
        'invokables' => array(
           'Acl\Controller\Acl' => 'Acl\Controller\AclController', 
        ),
    ),
    
    //routing part -------
    
    'router' => array(
        'routes' => array(
            'acl' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/acl',
                    'defaults' => array(
                        'controller' => 'Acl\Controller\Acl',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
        
    ),
    
   
    'view_manager' => array(
         'template_path_stack' => array(
             'acl' => __DIR__ . '/../view',
         ),
     ),
    
    
);
