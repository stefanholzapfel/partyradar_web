<?php

namespace Party\Controller;

use Party\Form\UserForm;
use Party\Model\User;
use Zend\Form\FormInterface;
use Party\Form\AbstractPartyForm;

class UserController extends AbstractActionController {

	public function indexAction() {
		$me = $this->getPartyRadarService();
		return array('users' => $me->getUsers());
	}

	public function addAction() {
		$form = new UserForm(AbstractPartyForm::MODE_ADD);
		/* @var $request \Zend\Http\Request */
		$request = $this->getRequest();
		if($request->isPost()) {
			$user = new User();
			$form->setInputFilter($user->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
				$user->exchangeArray($data);
				try {
					$this->getPartyRadarService()->addUser($user);
				} catch (\Exception $e) {
					$this->flashMessenger()->addErrorMessage($e->getMessage());
					return $this->redirect()->toRoute('party/user', array(
						'action' => 'index'
					));
				}

				$this->flashMessenger()->addSuccessMessage("User '" . $user->userName . "' successfully created!");
				return $this->redirect()->toRoute('party/user', array(
					'action' => 'index'
				));
			}
		}

		return array(
			'form' => $form,
		);
	}

	public function deleteAction() {
		$id = (string)$this->params()->fromRoute('id', 0);
		if (! $id) {
			return $this->redirect()->toRoute('party/user', array(
				'action' => 'index',
			));
		}
		try {
			$this->getPartyRadarService()->deleteUser($id);
		} catch (\Exception $e) {
			$this->flashMessenger()->addErrorMessage($e->getMessage());
			return $this->redirect()->toRoute('party/user', array(
				'action' => 'index',
			));
		}

		$this->flashMessenger()->addSuccessMessage("User successfully deleted!");
		return $this->redirect()->toRoute('party/user', array(
			'action' => 'index',
		));
	}

	public function editAction() {
		$id = (string)$this->params()->fromRoute('id', 0);
		if (!$id) {
			return $this->redirect()->toRoute('party/user', array(
				'action' => 'index',
			));
		}
		try {
			$user = $this->getPartyRadarService()->getUser($id);
		} catch (\Exception $e) {
			$this->flashMessenger()->addErrorMessage($e->getMessage());
			return $this->redirect()->toRoute('party/user', array(
				'action' => 'index'
			));
		}

		$form = new UserForm(AbstractPartyForm::MODE_EDIT);

		/* @var $request \Zend\Http\Request */
		$request = $this->getRequest();
		if($request->isPost()) {
			$user = new User();
			$form->setInputFilter($user->getUpdateInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
				$user->exchangeArray($data);
				try {
					$this->getPartyRadarService()->updateUser($user);
				} catch (\Exception $e) {
					$this->flashMessenger()->addErrorMessage($e->getMessage());
					return $this->redirect()->toRoute('party/user', array(
						'action' => 'edit'
					));
				}

				$this->flashMessenger()->addSuccessMessage("User '" . $user->userName . "' successfully updated!");
				return $this->redirect()->toRoute('party/user', array(
					'action' => 'index'
				));
			}
		}

		$form->bind($user);

		return array(
			'form' => $form,
			'username' => $user->userName,
			'id' => $user->id
		);
	}

}

?>