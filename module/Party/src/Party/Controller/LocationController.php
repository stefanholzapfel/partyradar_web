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

class LocationController extends AbstractActionController {

	public function indexAction() {

		$me = $this->getPartyRadarService();
		return array('test' => $me->getLocations());
	}

	public function editAction() {
		$form = new LocationForm();
		$id = (string)$this->params()->fromRoute('id', 0);
		if (! $id) {
			return $this->redirect()->toRoute('party/location', array(
				'action' => 'index',
			));
		}
		//try to fetch location object from service here...
		$location = new Location();
		$location->id = '239729837DHBWJD88d';
		$location->isInactive = false;
		$location->locationName = "TEEEEST";
		$location->country = "TESSTTT";
		$location->position = "ROFLDIEBOFFEL";
		$location->zipcode = "ROFLDIEBOFFEL 2";
		$location->address = "Komische Strasse 123";
		$location->maxAttends = 17;
		$form->bind($location);

		return array(
			'form' => $form,
			'id' => $location->id,
			'name' => $location->locationName
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
				//add location through service here --> DOES NOT WORK :-[[
				$this->flashMessenger()->addSuccessMessage("Location '" . $location->locationName . "' successfully created!");
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
