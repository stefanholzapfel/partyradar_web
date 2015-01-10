<?php

namespace Party\Service\Exceptions;

use Zend\Http\Response;
use Zend\Http\Request;
class PartyServiceException extends \Exception {

	public function __construct(Response $errorResponse, Request $errorRequest) {
		$errorContent = $errorResponse->getContent();
		$errorContentDecoded = \Zend\Json\Decoder::decode($errorContent, \Zend\Json\Json::TYPE_ARRAY);
		$responseMsg = 'Response: ';
		$responseMsg .= $errorResponse->getStatusCode();
		if(isset($errorContentDecoded['Message']))
			$responseMsg .= ' ' . $errorContentDecoded['Message'] . PHP_EOL;
		$requestMsg = 'Request:' . PHP_EOL;
		$requestMsg .= 'Content: ' . print_r($errorRequest->getPost()->toArray(), true) . PHP_EOL;
		$message = $responseMsg . $requestMsg;
		parent::__construct($message);
	}
}

?>