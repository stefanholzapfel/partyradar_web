<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Party\Controller\Location' => 'Party\Controller\LocationController',
        	'Party\Controller\Event' => 'Party\Controller\EventController',
        	'Party\Controller\User' => 'Party\Controller\UserController',
        	'Party\Controller\Dashboard' => 'Party\Controller\DashboardController'
        ),
    ),
	'service_manager' => array(
		'factories' => array(
			'Party\PartyService' => 'Party\Service\PartyServiceFactory'
		),
		'abstract_factories' => array(
			'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
			'Zend\Log\LoggerAbstractServiceFactory',
		),
		'aliases' => array(
			'translator' => 'MvcTranslator',
		),
	),
	'translator' => array(
		'locale' => 'en_US',
		'translation_file_patterns' => array(
			array(
				'type'     => 'gettext',
				'base_dir' => __DIR__ . '/../language',
				'pattern'  => '%s.mo',
			),
		),
	),
    'router' => array(
        'routes' => array(
        	'home' => array(
        		'type' => 'Zend\Mvc\Router\Http\Literal',
        		'options' => array(
        			'route'    => '/party',
        			'defaults' => array(
        				'controller' => 'Party\Controller\Dashboard',
        				'action'     => 'index',
        			),
        		),
        	),
            'party' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/party',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Party\Controller',
                        'controller'    => 'Dashboard',
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
    	'display_not_found_reason' => true,
    	'display_exceptions'       => true,
    	'doctype'                  => 'HTML5',
    	'not_found_template'       => 'error/404',
    	'exception_template'       => 'error/index',
    	'template_map' => array(
    		'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
    		'error/404'               => __DIR__ . '/../view/error/404.phtml',
    		'error/index'             => __DIR__ . '/../view/error/index.phtml',
    	),
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
