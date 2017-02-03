<?php
namespace EM3;

return array(
    
    'controllers' => array(
        'invokables' => array(
           'EM3\Controller\EM3' => 'EM3\Controller\EM3Controller', 
        ),
    ),
    
    //routing part -------
    
    'router' => array(
        'routes' => array(
            'em3' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/em3',
                    'defaults' => array(
                        'controller' => 'EM3\Controller\EM3',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
        
    ),
    
    
    'view_manager' => array(
         'template_path_stack' => array(
             'em3' => __DIR__ . '/../view',
         ),
     ),
    
    
);
