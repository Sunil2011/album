<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'Auth\Controller\Success' => 'Auth\Controller\SuccessController',
             
             'Auth\Controller\Auth' => 'Auth\Controller\AuthController',
           // 'logIn\Controller\Success' => 'logIn\Controller\SuccessController',
         ),
     ),

     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             
             'auth' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/auth[/:action][/:id]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Auth\Controller\Success',
                         'action'     => 'index',
                     ),
                 ),                
             ), 
             
             
             
             'login' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth',
                    'defaults' => array(
                        //'__NAMESPACE__' => 'logIn\Controller',
                        'controller'    => 'Auth\Controller\Auth',
                        'action'        => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/auth/[:action][/:id]',
                            'constraints' => array(
                                
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
             
             'logout' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth/logout',
                    'defaults' => array(
                        //'__NAMESPACE__' => 'logIn\Controller',
                        'controller'    => 'Auth\Controller\Auth',
                        'action'        => 'logout',
                    ),
                ),
                 ),
             
            'success' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/auth/success[/:action][/:id]',
                    
                    'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                        ),
                    'defaults' => array(
                        //'__NAMESPACE__' => 'logIn\Controller',
                        'controller'    => 'Auth\Controller\Success',
                        'action'        => 'index',
                    ),
                ),
                
                
            ),
             
             
             'add' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth/success/add',
                    'defaults' => array(
                        //'__NAMESPACE__' => 'logIn\Controller',
                        'controller'    => 'Auth\Controller\Success',
                        'action'        => 'add',
                     ),
                  ),
               ),
             
             'edit' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth/success/edit',
                    
                    'constraints' => array(
                         //'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                        ),
                    'defaults' => array(
                        
                        'controller'    => 'Auth\Controller\Success',
                        'action'        => 'edit',
                    ),
                 ),
                 
                 
              ),
             
             'delete' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/auth/success/delete',
                    'defaults' => array(
                        
                        'controller'    => 'Auth\Controller\Success',
                        'action'        => 'delete',
                    ),
                 ),
              ),
             
         ),
     ),

     'view_manager' => array(
         'template_path_stack' => array(
             'auth' => __DIR__ . '/../view',
         ),
     ),
 );