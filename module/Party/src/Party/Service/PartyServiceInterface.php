<?php

namespace Party\Service;

use Zend\Http\PhpEnvironment\Request;
use Party\Model\Location;
use Party\Model\User;
use Zend\Http\Client;
use Party\Service\Exceptions\PartyServiceException;
use Party\Model\Event;
use Party\Model\Keyword;

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
	 * @var \Zend\Http\Client
	 */
	protected $httpClient;

	/**
	 * serviceLocator
	 *
	 * @var \Zend\ServiceManager\ServiceLocatorInterface
	 */
	protected $serviceLocator;

	protected $config;

	public function __construct($config, \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
		$this->config = $config;
		$this->serviceLocator = $serviceLocator;
	}

	/**
	 * @param string $id GUID
	 * @throws PartyServiceException
	 * @return \Party\Model\User
	 */
	public function getUser($id) {
		$client = $this->prepareHttpClient(Request::METHOD_GET, $this->config['users'] . '/' . $id);
		$response = $client->send();

		if($response->isSuccess()) {
			$user = new User();
			$content = $response->getContent();
			$userData = \Zend\Json\Decoder::decode($content, \Zend\Json\Json::TYPE_ARRAY);
			$user->exchangeArray($userData);
			return $user;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 *
	 * @param User $user
	 * @throws PartyServiceException
	 * @return boolean
	 */
	public function updateUser(User $user) {
		$client = $this->prepareHttpClient(Request::METHOD_PUT, $this->config['users'] . '/' . $user->id);
		$client->setParameterPost($user->getServiceCopyForUpdate());
		$response = $client->send();
		if($response->isSuccess()) {
			return true;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * Adds a User to the Service
	 *
	 * @param User $user
	 */
	public function addUser(User $user) {
		$client = $this->prepareHttpClient(Request::METHOD_POST, $this->config['users']);
		$client->setParameterPost($user->getServiceCopy());
		$response = $client->send();
		if($response->isSuccess()) {
			return true;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 *
	 * @throws PartyServiceException
	 * @return multitype:\Party\Model\User
	 */
	public function getUsers() {
		$client = $this->prepareHttpClient(Request::METHOD_GET, $this->config['users']);
		$response = $client->send();
		if($response->isSuccess()) {
			$userContent = $response->getContent();
			$userArray = \Zend\Json\Decoder::decode($userContent, \Zend\Json\Json::TYPE_ARRAY);
			$return = array();
			foreach ($userArray as $userData) {
				$userToAdd = new User();
				$userToAdd->exchangeArray($userData);
				$return[] = $userToAdd;
			}
			return $return;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * @param string $id GUID
	 * @throws PartyServiceException
	 * @return boolean
	 */
	public function deleteUser($id) {
		$client = $this->prepareHttpClient(Request::METHOD_DELETE, $this->config['users'] . '/' . $id);
		$response = $client->send();
		if($response->isSuccess()) {
			return true;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 *
	 * @param string $id GUID
	 * @throws PartyServiceException
	 * @return \Party\Model\Location
	 */
	public function getLocation($id) {
		$client = $this->prepareHttpClient(Request::METHOD_GET, $this->config['locations'] . '/' . $id);
		$response = $client->send();

		if($response->isSuccess()) {
			$location = new Location();
			$content = $response->getContent();
			$locationData = \Zend\Json\Decoder::decode($content, \Zend\Json\Json::TYPE_ARRAY);
			$location->exchangeArray($locationData);
			return $location;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * @param Location $location
	 * @throws PartyServiceException
	 * @return boolean
	 */
	public function addLocation(Location $location) {
		$client = $this->prepareHttpClient(Request::METHOD_POST, $this->config['locations']);
		$client->setParameterPost($location->getServiceCopy());
		$response = $client->send();
		if($response->isSuccess()) {
			return true;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * @param Location $location
	 * @throws PartyServiceException
	 * @return boolean
	 */
	public function updateLocation(Location $location) {
		$client = $this->prepareHttpClient(Request::METHOD_PUT, $this->config['locations'] . '/' . $location->id);
		$client->setParameterPost($location->getServiceCopyForUpdate());
		$response = $client->send();
		if($response->isSuccess()) {
			return true;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * @throws PartyServiceException
	 * @return multitype:\Party\Model\Location
	 */
	public function getLocations() {
		$client = $this->prepareHttpClient(Request::METHOD_GET, $this->config['locations']);
		$response = $client->send();
		if($response->isSuccess()) {
			$locationContent = $response->getContent();
			$locationArray = \Zend\Json\Decoder::decode($locationContent, \Zend\Json\Json::TYPE_ARRAY);
			$return = array();
			foreach ($locationArray['Result'] as $locationData) {
				$locationToAdd = new Location();
				$locationToAdd->exchangeArray($locationData);
				$return[] = $locationToAdd;
			}
			return $return;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * @param string $id GUID
	 * @throws PartyServiceException
	 * @return boolean
	 */
	public function deleteLocation($id) {
		$client = $this->prepareHttpClient(Request::METHOD_DELETE, $this->config['locations'] . '/' . $id);
		$response = $client->send();
		if($response->isSuccess()) {
			return true;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * @throws PartyServiceException
	 * @return multitype:\Party\Model\Location
	 */
	public function getEvents() {
		$client = $this->prepareHttpClient(Request::METHOD_GET, $this->config['events']);
		$response = $client->send();
		if($response->isSuccess()) {
			$eventContent = $response->getContent();
			$eventArray = \Zend\Json\Decoder::decode($eventContent, \Zend\Json\Json::TYPE_ARRAY);
			$return = array();
			foreach ($eventArray as $eventData) {
				$eventToAdd = new Event();
				$eventToAdd->exchangeArray($eventData);
				$return[] = $eventToAdd;
			}
			return $return;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * @param string $id GUID
	 * @throws PartyServiceException
	 * @return \Party\Model\Event
	 */
	public function getEvent($id) {
		$client = $this->prepareHttpClient(Request::METHOD_GET, $this->config['events'] . '/' . $id);
		$response = $client->send();

		if($response->isSuccess()) {
			$event = new Event();
			$content = $response->getContent();
			$eventData = \Zend\Json\Decoder::decode($content, \Zend\Json\Json::TYPE_ARRAY);
			$event->exchangeArray($eventData);
			return $event;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * @param Event $event
	 * @throws PartyServiceException
	 * @return boolean
	 */
	public function addEvent(Event $event) {
		$client = $this->prepareHttpClient(Request::METHOD_POST, $this->config['events']);
		$client->setParameterPost($event->getServiceCopy());
		$response = $client->send();
		if($response->isSuccess()) {
			return true;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * @param Event $event
	 * @throws PartyServiceException
	 * @return boolean
	 */
	public function updateEvent(Event $event) {
		$client = $this->prepareHttpClient(Request::METHOD_PUT, $this->config['events'] . '/' . $event->eventId);
		$client->setParameterPost($event->getServiceCopyForUpdate());
		$response = $client->send();
		if($response->isSuccess()) {
			return true;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * @param string $id GUID
	 * @throws PartyServiceException
	 * @return boolean
	 */
	public function deleteEvent($id) {
		$client = $this->prepareHttpClient(Request::METHOD_DELETE, $this->config['events'] . '/' . $id);
		$response = $client->send();
		if($response->isSuccess()) {
			return true;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 * @throws PartyServiceException
	 * @return multitype:\Party\Model\Keyword
	 */
	public function getKeywords() {
		$client = $this->prepareHttpClient(Request::METHOD_GET, $this->config['keywords']);
		$response = $client->send();
		if($response->isSuccess()) {
			$keywordContent = $response->getContent();
			$keywordArray = \Zend\Json\Decoder::decode($keywordContent, \Zend\Json\Json::TYPE_ARRAY);
			$return = array();
			foreach ($keywordArray as $keywordData) {
				$keywordToAdd = new Keyword();
				$keywordToAdd->exchangeArray($keywordData);
				$return[] = $keywordToAdd;
			}
			return $return;
		} else {
			throw new PartyServiceException($response);
		}
	}

	/**
	 *
	 * @param string $method
	 * @param string $api
	 * @throws \Exception
	 * @return \Zend\Http\Client
	 */
	protected function prepareHttpClient($method, $api) {
		$token = $this->getPartyRadarService()->getSessionToken();
		if(!$token) {
			throw new \Exception('not authenticated for this action');
		} else {
			$stdHeader = array(
				'Authorization' => 'Bearer ' . $token->access_token,
				'Content-Type' => 'application/x-www-form-urlencoded'
			);
			$client = $this->getHttpclient()
				->resetParameters(true)
				->setHeaders($stdHeader)
				->setMethod($method)
				->setUri($this->getPartyRadarService()->getUrl() . $api);

			return $client;
		}
	}

	/**
	 * @return \Zend\Http\Client
	 */
	protected function getHttpClient() {
		if (! $this->httpClient) {
			$this->httpClient = new Client(null, array(
				'timeout' => 60,
				'adapter' => '\Zend\Http\Client\Adapter\Curl'
			));
		}
		return $this->httpClient;
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