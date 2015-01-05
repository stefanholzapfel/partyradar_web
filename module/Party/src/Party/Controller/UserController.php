<?php

namespace Party\Controller;

use Party\Form\UserForm;
use Party\Model\User;
use Zend\Form\FormInterface;

class UserController extends AbstractActionController {

	public function indexAction() {
		$me = $this->getPartyRadarService();
		return array('users' => $me->getUsers());
	}

	public function addAction() {
		$form = new UserForm();
		/* @var $request \Zend\Http\Request */
		$request = $this->getRequest();
		if($request->isPost()) {
			$user = new User();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
				$user->exchangeArray($data);
				//add location through service here --> DOES NOT WORK :-[[
				$this->flashMessenger()->addSuccessMessage("User '" . $user->userName . "' successfully created!");
				return array(
					'form' => $form,
				);
			}
		}

		return array(
			'form' => $form,
		);
	}

}

?>