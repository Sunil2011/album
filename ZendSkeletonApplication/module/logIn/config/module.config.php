<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'logIn\Controller\logIn' => 'logIn\Controller\logInController',
            'logIn\Controller\Success' => 'logIn\Controller\SuccessController'
        ),
    ),
    'router' => array(
        'routes' => array(
             
            'login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/login',
                    'defaults' => array(
                        //'__NAMESPACE__' => 'logIn\Controller',
                        'controller'    => 'logIn\Controller\logIn',
                        'action'        => 'login',
                    ),
                ),
                
            ),
             
            /*'success' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/success',
                    'defaults' => array(
                        //'__NAMESPACE__' => 'logIn\Controller',
                        'controller'    => 'logIn\Controller\Success',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
               'success' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/success',
                    'defaults' => array(
                        //'__NAMESPACE__' => 'logIn\Controller',
                        'controller'    => 'logIn\Controller\Success',
                           ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),*/
             
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'log-in' => __DIR__ . '/../view',
        ),
    ),
    );