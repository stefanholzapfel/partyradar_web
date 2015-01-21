<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Authentication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Authentication\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Authentication\AuthenticationService;

class AuthController extends AbstractActionController {

	public function indexAction() {
		$auth = new AuthenticationService();
		if($auth->hasIdentity())
			$this->redirect()->toRoute('home');
		return array();
	}

	public function loginAction() {
		if ($this->request->isPost()) {
			/* @var $me \ReverseOAuth2\Client\PartyRadar */
			$me = $this->getServiceLocator()->get('ReverseOAuth2\PartyRadar');
			$auth = new AuthenticationService();

			if ($me->getToken($this->request)) {
				$token = $me->getSessionToken();
			} else {
				$token = $me->getError();
			}
			/*  @var $adapter \ReverseOAuth2\Authentication\Adapter\ReverseOAuth2 */
			$adapter = $this->getServiceLocator()->get('ReverseOAuth2\Auth\Adapter');
			$adapter->setOAuth2Client($me);
			$rs = $auth->authenticate($adapter);

			if (!$rs->isValid()) {
				$this->flashMessenger()->addErrorMessage("username or password incorrect");
				$this->redirect()->toRoute('auth');
			}
			$this->redirect()->toRoute('home');
		}
	}

	public function logoutAction() {
		$auth = new AuthenticationService();
		$auth->clearIdentity();
		$this->redirect()->toRoute('auth');
	}
}

?>