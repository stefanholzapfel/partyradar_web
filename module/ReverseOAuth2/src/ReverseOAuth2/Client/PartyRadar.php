<?php

namespace ReverseOAuth2\Client;

use ReverseOAuth2\AbstractOAuth2Client;
use Zend\Http\PhpEnvironment\Request;

class PartyRadar extends AbstractOAuth2Client {

	protected $providerName = 'partyradar';

	public function getUrl() {
		$url = $this->options->getUri();
		return $url;
	}

	/**
	 * call
	 *
	 * @param string $method
	 * @param string $api
	 * @param string $params
	 * @param array $additionalHeaders
	 * @throws \Exception
	 * @return Ambigous <\Zend\Json\mixed, NULL, \Zend\Json\$_tokenValue, multitype:, multitype:Ambigous <\Zend\Json\mixed, \Zend\Json\$_tokenValue, NULL> , stdClass, multitype:Ambigous <\Zend\Json\mixed, \Zend\Json\$_tokenValue, multitype:, multitype:Ambigous <\Zend\Json\mixed, \Zend\Json\$_tokenValue, NULL> , NULL> >
	 *
	 */
	public function call($method, $api, $params = '', $additionalHeaders = array()) {
		if(!isset($this->session->token)) {
			throw new \Exception('not authenticated for this action');
		} else {
			$stdHeader = array(
				'Authorization' => 'Bearer ' . $this->session->token->access_token,
			);
			if(count($additionalHeaders) > 0)
				$headers = array_merge($stdHeader, $additionalHeaders);
			else
				$headers = $stdHeader;
			$client = $this->getHttpclient()
			->resetParameters(true)
			->setHeaders($headers)
			->setMethod($method)
			->setUri($this->getUrl() . $api . $params);


			$retVal = $client->send()->getContent();

			return \Zend\Json\Decoder::decode($retVal, \Zend\Json\Json::TYPE_ARRAY);

		}
	}

	public function getToken(Request $request) {
		if(isset($this->session->token)) {

			return true;

		} else {

			$client = $this->getHttpClient();

			$client->setUri($this->options->getTokenUri());

			$client->setMethod(Request::METHOD_POST);

			$client->setParameterPost(array(
				'grant_type' => 'password',
				'username' => $request->getPost('username'),
				'password' => $request->getPost('password')
			));

			$client->setEncType('application/x-www-form-urlencoded');

			$retVal = $client->send()->getContent();

			$token = \Zend\Json\Decoder::decode($retVal, \Zend\Json\Json::TYPE_ARRAY);

			if(is_array($token) AND isset($token['access_token']) AND $token['expires_in'] > 0) {

				$this->session->token = (object)$token;
				return true;

			} else {

				try {

					$error = \Zend\Json\Decoder::decode($retVal);

					$this->error = array(
						'internal-error' => 'PartyRadar internal error.',
						'message' => $error->error_description,
						'type' => $error->error
					);

				} catch(\Zend\Json\Exception\RuntimeException $e) {

					$this->error = $token;
					$this->error['internal-error'] = 'Unknown error.';

				}

				return false;

			}
		}
	}

	public function getInfo() {
		if(is_object($this->session->info)) {

			return $this->session->info;

		} elseif(isset($this->session->token->access_token)) {

			$urlProfile = $this->options->getInfoUri();

			$client = $this->getHttpclient()
				->resetParameters(true)
				->setHeaders(array(
					'Accept-encoding' => 'utf-8',
					'Authorization' => 'Bearer ' . $this->session->token->access_token
				))
				->setMethod(Request::METHOD_GET)
				->setUri($urlProfile);

			$retVal = $client->send()->getContent();

			if(strlen(trim($retVal)) > 0) {

				$this->session->info = \Zend\Json\Decoder::decode($retVal);
				return $this->session->info;

			} else {

				$this->error = array('internal-error' => 'Get info return value is empty.');
				return false;

			}

		} else {

			$this->error = array('internal-error' => 'Session access token not found.');
			return false;

		}
	}
}

?>