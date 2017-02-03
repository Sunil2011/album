<?php

return array(
     'controllers' => array(
        'invokables' => array(
            'jQuery\Controller\jQuery' => 'jQuery\Controller\jQueryController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'jquery' => array(
                'type'    => 'literal',
                'options' => array(
                    'route'    => '/jquery',
                   
                    'defaults' => array(
                        'controller' => 'jQuery\Controller\jQuery',
                        'action' => 'index'
                    ),
                ),
            ),
        ),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'jquery' => __DIR__ . '/../view',
        ),
    ),
    
);
        

