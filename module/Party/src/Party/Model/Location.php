<?php

namespace Party\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;

class Location extends AbstractPartyModel implements InputFilterAwareInterface {

	public $id;

	public $locationName;

	public $lon;

	public $lat;

	public $address;

	public $addressAdditions;

	public $zipcode;

	public $city;

	public $country;

	public $maxAttends;

	public $isInactive;

	public function exchangeArray($data = array()) {
		if(count($data) > 0 && !is_null($data)) {
			$this->id= isset($data['LocationID']) ? $data['LocationID'] : null;
			$this->locationName = isset($data['locationName']) ? $data['locationName'] : null;
			$this->lon = isset($data['lon']) ? $data['lon'] : null;
			$this->lat = isset($data['lat']) ? $data['lat'] : null;
			$this->address = isset($data['address']) ? $data['address'] : null;
			$this->addressAdditions = isset($data['addressAdditions']) ? $data['addressAdditions'] : null;
			$this->city = isset($data['city']) ? $data['city'] : null;
			$this->zipcode = isset($data['zipcode']) ? $data['zipcode'] : null;
			$this->country = isset($data['country']) ? $data['country'] : null;
			$this->maxAttends = isset($data['maxAttends']) ? $data['maxAttends'] : null;
			$this->isInactive = isset($data['isInactive']) ? $data['isInactive'] : null;
		}
	}

	public function getArrayCopy() {
		return get_object_vars($this);
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
				'name'     => 'id',
				'required' => false,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'locationName',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'lon',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'lat',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'address',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'addressAdditions',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'zipcode',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'city',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'country',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'maxAttends',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'isInactive',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}



}

?>