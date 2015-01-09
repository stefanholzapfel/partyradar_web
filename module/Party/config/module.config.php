<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Party\Controller\Location' => 'Party\Controller\LocationController',
        	'Party\Controller\Event' => 'Party\Controller\EventController',
        	'Party\Controller\User' => 'Party\Controller\UserController'
        ),
    ),
	'service_manager' => array(
		'factories' => array(
			'Party\PartyService' => 'Party\Service\PartyServiceFactory'
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
                        'type'    => 'segment',
                        'options' => array(
                        	'route'    => '/location[/][:action][/:id]',
                        	'constraints' => array(
                        		'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        		'id'     => '[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}',
                        	),
                            'defaults' => array(
                            	'__NAMESPACE__' => 'Party\Controller',
                            	'controller'    => 'Location',
                            	'action'        => 'index',
                            ),
                        ),
                    ),
                	'event' => array(
                		'type'    => 'segment',
                        'options' => array(
                        	'route'    => '/event[/][:action][/:id]',
                        	'constraints' => array(
                        		'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        		'id'     => '[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}',
                        	),
                			'defaults' => array(
                				'__NAMESPACE__' => 'Party\Controller',
                				'controller'    => 'Event',
                				'action'        => 'index',
                			),
                		),
                	),
                	'user' => array(
                		'type'    => 'segment',
                		'options' => array(
                			'route'    => '/user[/][:action][/:id]',
                			'constraints' => array(
                				'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                				'id'     => '[a-zA-Z0-9]{8}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{4}-[a-zA-Z0-9]{12}',
                			),
                			'defaults' => array(
                				'__NAMESPACE__' => 'Party\Controller',
                				'controller'    => 'User',
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
	'service_config' => array(
		'locations' => 'api/Location',
		'events' => 'api/Event',
		'users' => 'api/User',
		'keywords' => 'api/Keyword'
	),
);
