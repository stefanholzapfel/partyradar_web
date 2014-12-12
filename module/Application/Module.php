<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Authentication\AuthenticationService;

class Module {

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
			'Zend\Loader\StandardAutoloader' => array(
				'namespaces' => array(
					__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
				),
            ),
        );
    }
}
