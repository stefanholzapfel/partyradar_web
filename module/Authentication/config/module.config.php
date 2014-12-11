<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Authentication\Controller\Auth' => 'Authentication\Controller\AuthController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'auth' => array(
                'type'    => 'Segment',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/auth[/][:action]',
                	'constraints' => array(
                		'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                	),
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Authentication\Controller',
                        'controller'    => 'Auth',
                        'action'        => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Authentication' => __DIR__ . '/../view',
        ),
    ),
);
