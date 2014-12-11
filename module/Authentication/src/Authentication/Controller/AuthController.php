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
		return array();
	}

	public function loginAction() {
		if($this->request->isPost()) {
			/* @var $me \ReverseOAuth2\Client\PartyRadar */
			$me = $this->getServiceLocator()->get('ReverseOAuth2\PartyRadar');
			$auth = new AuthenticationService();

			if($me->getToken($this->request)) {
				$token = $me->getSessionToken();
			} else {
				$token = $me->getError();
			}

			$info = $me->getInfo();

			$view = array('token' => $token, 'info' => $info, 'error' => $me->getError());


			return $view;
		}
	}
}

?>