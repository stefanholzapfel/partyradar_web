<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Party\Controller\Location' => 'Party\Controller\LocationController',
        	'Party\Controller\Event' => 'Party\Controller\EventController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'party' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/party',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Party\Controller',
                        'controller'    => 'Location',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'location' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/location',
                            'defaults' => array(
                            	'__NAMESPACE__' => 'Party\Controller',
                            	'controller'    => 'Location',
                            	'action'        => 'index',
                            ),
                        ),
                    ),
                	'event' => array(
                		'type'    => 'Literal',
                		'options' => array(
                			'route'    => '/event',
                			'defaults' => array(
                				'__NAMESPACE__' => 'Party\Controller',
                				'controller'    => 'Event',
                				'action'        => 'index',
                			),
                		),
                	),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'Party' => __DIR__ . '/../view',
        ),
    ),
);
