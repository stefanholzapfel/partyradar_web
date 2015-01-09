<?php

namespace Party\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;

class Location extends AbstractPartyModel implements InputFilterAwareInterface {

	public $id;

	public $name;

	public $longitude;

	public $latitude;

	public $address;

	public $addressAdditions;

	public $zipcode;

	public $city;

	public $country;

	public $maxAttends;

	public function exchangeArray($data = array()) {
		if(count($data) > 0 && !is_null($data)) {
			$this->id= isset($data['Id']) ? $data['Id'] : null;
			$this->name = isset($data['Name']) ? $data['Name'] : null;
			$this->longitude = isset($data['Longitude']) ? $data['Longitude'] : null;
			$this->latitude = isset($data['Latitude']) ? $data['Latitude'] : null;
			$this->address = isset($data['Address']) ? $data['Address'] : null;
			$this->addressAdditions = isset($data['AddressAdditions']) ? $data['AddressAdditions'] : null;
			$this->city = isset($data['City']) ? $data['City'] : null;
			$this->zipcode = isset($data['ZipCode']) ? $data['ZipCode'] : null;
			$this->country = isset($data['Country']) ? $data['Country'] : null;
			$this->maxAttends = isset($data['MaxAttends']) ? $data['MaxAttends'] : null;
		}
	}

	public function getArrayCopy() {
		$vars = array(
			'Id' => $this->id,
			'Name' => $this->name,
			'Longitude' => $this->longitude,
			'Latitude' => $this->latitude,
			'Address' => $this->address,
			'AddressAdditions' => $this->addressAdditions,
			'City' => $this->city,
			'ZipCode' => $this->zipcode,
			'Country' => $this->country,
			'MaxAttends' => $this->maxAttends,
		);
		return $vars;
	}

	public function getServiceCopyForUpdate() {
		$vars = $this->getArrayCopy();

		return $vars;
	}

	public function getServiceCopy() {
		return $this->getArrayCopy();
	}

	/* (non-PHPdoc)
	 * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
	 */
	public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter) {
		throw new \Exception('Not used');
	}

	/* (non-PHPdoc)
	 * @see \Zend\InputFilter\InputFilterAwareInterface::getInputFilter()
	 */
	public function getInputFilter() {
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name'     => 'Id',
				'required' => false,
			));

			$inputFilter->add(array(
				'name'     => 'Name',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'Longitude',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => array(
					array(
						'name' => 'Float'
					),
				),
			));

			$inputFilter->add(array(
				'name'     => 'Latitude',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => array(
					array(
						'name' => 'Float'
					),
				),
			));

			$inputFilter->add(array(
				'name'     => 'Address',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'AddressAdditions',
				'required' => false,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'ZipCode',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'City',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'Country',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'MaxAttends',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => array(
					array(
						'name' => 'Digits'
					),
				),
			));

			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}



}

?>