<?php

namespace Party\Service;

use Zend\ServiceManager\FactoryInterface;
/**
 *
 * @author AT21572
 *
 */
class PartyServiceFactory implements FactoryInterface {

	/* (non-PHPdoc)
	 * @see \Zend\ServiceManager\FactoryInterface::createService()
	 */
	public function createService(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator) {
		$config = $serviceLocator->get('Config');
		return new PartyServiceInterface($config['service_config'], $serviceLocator);
	}



}

?>