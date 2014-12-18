<?php

namespace Party\Controller;

use Zend\Mvc\Controller\AbstractActionController as ZfAbstractActionController;

class AbstractActionController extends ZfAbstractActionController {

	/**
	 *  @var \ReverseOAuth2\Client\PartyRadar
	 */
	protected $partyService;

	/**
	 *
	 * @return \ReverseOAuth2\Client\PartyRadar
	 */
	public function getPartyRadarService() {
		if(!$this->partyService) {
			$this->partyService = $this->getServiceLocator()->get('ReverseOAuth2\PartyRadar');
		}
		return $this->partyService;
	}
}

?>