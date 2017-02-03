<?php

return array(
     'controllers' => array(
         'invokables' => array(
             'Students\Controller\StLog' => 'Students\Controller\StLogController',
             
             'Students\Controller\StLogSucc' => 'Students\Controller\StLogSuccController',
           // 'logIn\Controller\Success' => 'logIn\Controller\SuccessController',
         ),
     ),
    
    
    'router' => array(
        'routes' => array(
            
             'login1' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/students',
                    'defaults' => array(
                        'controller'    => 'Students\Controller\StLog',
                        'action'        => 'login',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            
          /*  'login' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/students[/:action]' ,
                    'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        ),
                    'defaults' => array(
                        'controller' => 'Students\Controller\StLog',
                        'action' => 'login',
                    ),
                ),
            ),
            
             'logout' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/students/logout',
                    'defaults' => array(
                        'controller'    => 'Students\Controller\StLog',
                        'action'        => 'logout',
                        ),
                    ),
                 ),*/
            
            'success1' => array(
                'type'    => 'Segment',
                'options' => array(
                   /* 'route'    => '/students/success[/:action][/:id]',
                    
                    'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                        ),
                    'defaults' => array(
                        'controller'    => 'Students\Controller\StLogSucc',
                        'action'        => 'index',
                        ),*/
                    //below one for routing and sorting
                    
                    'route'    => '/students/success[/:action][/:id][/page/:page][/order_by/:order_by][/:order]',
                    'constraints' => array(
                        'action' => '(?!\bpage\b)(?!\border_by\b)[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                        'page' => '[0-9]+',
                        'order_by' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'order' => 'ASC|DESC',
                    ),
                    'defaults' => array(
                        'controller' => 'Students\Controller\StLogSucc',
                        'action'     => 'index',
                    ),
                    ),
                ),
            
           /* 'success1' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/students/success',
                    'defaults' => array(
                        'controller'    => 'Students\Controller\StLogSucc',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'process' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                ),
            ),
            */
            
            
            'add1' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/students/success/add',
                    'defaults' => array(
                        'controller'    => 'Students\Controller\StLogSucc',
                        'action'        => 'add',
                     ),
                  ),
               ),
            
            
             'edit1' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/students/success/edit',
                    
                    'constraints' => array(
                         //'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                        ),
                    'defaults' => array(
                        
                        'controller'    => 'Students\Controller\StLogSucc',
                        'action'        => 'edit',
                    ),
                 ),
                 
                 
              ),
            
             'delete1' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/students/success/delete',
                    'defaults' => array(
                        
                        'controller'    => 'Students\Controller\StLogSucc',
                        'action'        => 'delete',
                    ),
                 ),
              ),
             
            
            
        ),
    ),
    
    
    'view_manager' => array(
         'template_path_stack' => array(
             'students' => __DIR__ . '/../view',
         ),
        // below one is addede for pagination and sorting
        'template_map' => array( 
            'paginator-slide' => __DIR__ . '/../view/layout/slidePaginator.phtml',
        ),
     ),
    
    
    );
