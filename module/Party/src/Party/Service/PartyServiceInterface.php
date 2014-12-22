<?php

namespace Party\Service;

use Zend\Http\PhpEnvironment\Request;
use Party\Model\Location;
/**
 *
 * @author AT21572
 *
 */
class PartyServiceInterface {

	/**
	 *  @var \ReverseOAuth2\Client\PartyRadar
	 */
	protected $partyService;

	/**
	 * serviceLocator
	 *
	 * @var \Zend\ServiceManager\ServiceLocatorInterface
	 */
	protected $serviceLocator;

	protected $config;

	public function __construct($config, \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
		$this->setOptions($config);
		$this->serviceLocator = $serviceLocator;
	}

	public function setOptions($options) {
		$this->config = $options;
	}

	public function getLocations() {
		return $this->getPartyRadarService()->call(Request::METHOD_GET, $this->config['locations']);
	}

	/**
	 * getLocation
	 *
	 * @param string $id
	 * @return \Party\Model\Location
	 */
	public function getLocation($id) {
		$data = $this->getPartyRadarService()->call(Request::METHOD_GET, $this->config['locations'], $id);
		$location = new Location();
		$location->exchangeArray($data);
		return $location;
	}

	public function updateLocation(Location $location) {
		$this->getPartyRadarService()->call(Request::METHOD_PUT, $this->config['locations'], $location->id);
	}

	public function getEvents() {
		return $this->getPartyRadarService()->call(Request::METHOD_GET, $this->config['events']);
	}

	/**
	 *
	 * @return \ReverseOAuth2\Client\PartyRadar
	 */
	protected function getPartyRadarService() {
		if(!$this->partyService) {
			$this->partyService = $this->serviceLocator->get('ReverseOAuth2\PartyRadar');
		}
		return $this->partyService;
	}

}

?>