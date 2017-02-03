<?php

return array(
     'controllers' => array(
         'invokables' => array(
            'Stzs\Controller\StzsLog' => 'Stzs\Controller\StzsLogController',
             
            'Stzs\Controller\StzsLogSuc' => 'Stzs\Controller\StzsLogSucController',
            
             'Stzs\Controller\StzsLogSucAng' => 'Stzs\Controller\StzsLogSucAngController',
             'Stzs\Controller\StzsLogAng' => 'Stzs\Controller\StzsLogAngController'
        
         ),
     ),
    
    
    'router' => array(
        'routes' => array(
            
            'login2' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/stzs',
                    'defaults' => array(
                        'controller'    => 'Stzs\Controller\StzsLog',
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
            
         
            
            'success2' => array(
                'type'    => 'Segment',
                'options' => array(
                   'route'    => '/stzs/success[/:action][/:id]',
                    
                    'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'id'     => '[0-9]+',
                        ),
                    'defaults' => array(
                        'controller'    => 'Stzs\Controller\StzsLogSuc',
                        'action'        => 'index',
                    ),
                ),
            ),
            

            
            'JSONdata' => array(
                'type' => 'Segment',
                'options' => array(
                    'route'=> '/stzs/success/data[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Stzs\Controller\StzsLogSuc',
                        'action' => 'getJson',
                    ),
                ),
            ),
            
            
            'angular' =>array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/stzs/angular[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Stzs\Controller\StzsLogSucAng',
                        'action' => 'index' ,
                    ),
                ),
            ),
            
            
            'angularLog' => array(
                'type' => 'Segment' ,
                'options' => array(
                    'route' => '/stzs/angularLog[/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Stzs\Controller\StzsLogAng',
                        'action' => 'authenticate' ,
                    ),
                ),
            ),
           
            
        ),
    ),
    
    
    'view_manager' => array(
        'template_path_stack' => array(
            'stzs' => __DIR__ . '/../view',
        ),
        
        // for JSON file return
        'strategies' => array(
            'ViewJsonStrategy',
        ),
        
    ),
    
    
);
