<?php

namespace EM;

return array(
    
    'controllers' => array(
        'invokables' => array(
           'EM\Controller\EM' => 'EM\Controller\EMController', 
        ),
    ),
    
    //routing part -------
    
    'router' => array(
        'routes' => array(
            'em' => array(
                'type' => 'literal',
                'options' => array(
                    'route' => '/em',
                    'defaults' => array(
                        'controller' => 'EM\Controller\EM',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
        
    ),
    
   
    'view_manager' => array(
         'template_path_stack' => array(
             'em' => __DIR__ . '/../view',
         ),
     ),
    
    
);
