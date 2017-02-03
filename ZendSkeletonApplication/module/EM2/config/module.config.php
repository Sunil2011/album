<?php
namespace EM2;

return array(
    
    'controllers' => array(
        'invokables' => array(
           'EM2\Controller\EM2' => 'EM2\Controller\EM2Controller', 
        ),
    ),
    
    //routing part -------
    
    'router' => array(
        'routes' => array(
            'em2' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/em2',
                    'defaults' => array(
                        'controller' => 'EM2\Controller\EM2',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
        
    ),
    
    
    'view_manager' => array(
         'template_path_stack' => array(
             'em2' => __DIR__ . '/../view',
         ),
     ),
    
    
);

    