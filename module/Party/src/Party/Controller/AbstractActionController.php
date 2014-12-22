<?php

namespace Party\Controller;

use Zend\Mvc\Controller\AbstractActionController as ZfAbstractActionController;

class AbstractActionController extends ZfAbstractActionController {

	/**
	 *  @var \Party\Service\PartyServiceInterface
	 */
	protected $partyService;

	/**
	 *
	 * @return \Party\Service\PartyServiceInterface
	 */
	public function getPartyRadarService() {
		if(!$this->partyService) {
			$this->partyService = $this->getServiceLocator()->get('Party\PartyService');
		}
		return $this->partyService;
	}
}

?>