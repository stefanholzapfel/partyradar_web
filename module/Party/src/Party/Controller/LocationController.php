<?php

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Party for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Party\Controller;

use Party\Form\LocationForm;
use Party\Model\Location;
use Zend\Form\FormInterface;
use Party\Service\Exceptions\PartyServiceException;

class LocationController extends AbstractActionController {

	public function indexAction() {
		$me = $this->getPartyRadarService();
		return array('locations' => $me->getLocations());
	}

	public function deleteAction() {
		$id = (string)$this->params()->fromRoute('id', 0);
		if (! $id) {
			return $this->redirect()->toRoute('party/location', array(
				'action' => 'index',
			));
		}
		try {
			$this->getPartyRadarService()->deleteLocation($id);
		} catch (\Exception $e) {
			$this->flashMessenger()->addErrorMessage($e->getMessage());
			return $this->redirect()->toRoute('party/location', array(
				'action' => 'index',
			));
		}

		$this->flashMessenger()->addSuccessMessage("Location successfully deleted!");
		return $this->redirect()->toRoute('party/location', array(
			'action' => 'index',
		));
	}

	public function editAction() {
		$form = new LocationForm();
		$id = (string)$this->params()->fromRoute('id', 0);
		if (! $id) {
			return $this->redirect()->toRoute('party/location', array(
				'action' => 'index',
			));
		}
		try {
			$location = $this->getPartyRadarService()->getLocation($id);
		} catch (\Exception $e) {
			$this->flashMessenger()->addErrorMessage($e->getMessage());
			return $this->redirect()->toRoute('party/location', array(
				'action' => 'index',
			));
		}

		/* @var $request \Zend\Http\Request */
		$request = $this->getRequest();
		if($request->isPost()) {
			$location = new Location();
			$form->setInputFilter($location->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
				$location->exchangeArray($data);
				try {
					$this->getPartyRadarService()->updateLocation($location);
				} catch (\Exception $e) {
					$this->flashMessenger()->addErrorMessage($e->getMessage());
					return $this->redirect()->toRoute('party/location', array(
						'action' => 'edit'
					));
				}

				$this->flashMessenger()->addSuccessMessage("Location '" . $location->name . "' successfully updated!");
				return $this->redirect()->toRoute('party/location', array(
					'action' => 'index'
				));
			}
		}

		$form->bind($location);

		return array(
			'form' => $form,
			'id' => $location->id,
			'name' => $location->name
		);
	}

	public function addAction() {
		$form = new LocationForm();
		/* @var $request \Zend\Http\Request */
		$request = $this->getRequest();
		if($request->isPost()) {
			$location = new Location();
			$form->setInputFilter($location->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
				$location->exchangeArray($data);
				try {
					$this->getPartyRadarService()->addLocation($location);
				} catch (\Exception $e) {
					$this->flashMessenger()->addErrorMessage($e->getMessage());
					return $this->redirect()->toRoute('party/location', array(
						'action' => 'add',
					));
				}

				$this->flashMessenger()->addSuccessMessage("Location '" . $location->name . "' successfully created!");
				return $this->redirect()->toRoute('party/location', array(
					'action' => 'index'
				));
			}
		}

		return array(
			'form' => $form,
		);
	}
}
