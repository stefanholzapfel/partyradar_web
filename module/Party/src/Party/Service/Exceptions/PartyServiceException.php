<?php

namespace Party\Service\Exceptions;

use Zend\Http\Response;
class PartyServiceException extends \Exception {

	public function __construct(Response $errorResponse) {
		$errorContent = $errorResponse->getContent();
		$errorContentDecoded = \Zend\Json\Decoder::decode($errorContent, \Zend\Json\Json::TYPE_ARRAY);
		$message = $errorResponse->getStatusCode();
		if(isset($errorContentDecoded['Message']))
			$message .= ' ' . $errorContentDecoded['Message'];
		parent::__construct($message);
	}
}

?>