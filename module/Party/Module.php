<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Party for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Party;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;

class Module implements AutoloaderProviderInterface {

	protected $whitelist = array(
		'auth/login',
		'auth'
	);

	public function onBootstrap(MvcEvent $e) {
		$eventManager = $e->getApplication()->getEventManager();
		$moduleRouteListener = new ModuleRouteListener();
		$moduleRouteListener->attach($eventManager);

		$app = $e->getApplication();
		$sm = $app->getServiceManager();
		$allowedRoutes = $this->whitelist;
		$auth = new AuthenticationService();
		$eventManager->attach(\Zend\Mvc\MvcEvent::EVENT_ROUTE, function ($e) use($auth, $allowedRoutes) {
			$app = $e->getApplication();
			$routeMatch = $e->getRouteMatch();
			$routeName = $routeMatch->getMatchedRouteName();
			if (! $auth->hasIdentity() && ! in_array($routeName, $allowedRoutes)) {
				$response = $e->getResponse();
				$response->getHeaders()->addHeaderLine('Location', $e->getRouter()->assemble(array(), array(
					'name' => 'auth'
				)));
				$response->setStatusCode(302);
				return $response;
			} else {
				return;
			}
		}, - 100);
	}

	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
	}

	public function getAutoloaderConfig() {
		return array(
			'Zend\Loader\ClassMapAutoloader' => array(
				__DIR__ . '/autoload_classmap.php'
			),
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(

					// if we're in a namespace deeper than one level we need to fix the \ in the path
					__NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
		);
	}
}
