<?php

namespace Party\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;

class Event extends AbstractPartyModel implements InputFilterAwareInterface {

	public $id;

	public $title;

	public $description;

	public $website;

	public $start;

	public $end;

	public $locationID;

	public $keywords;

	public $attendeeCount;

	public $image;

	public function getArrayCopy() {
		return get_object_vars($this);
	}

	public function exchangeArray($data = array()) {
		if(count($data) > 0 && !is_null($data)) {
			$this->id= isset($data['EventID']) ? $data['EventID'] : null;
			$this->title = isset($data['title']) ? $data['title'] : null;
			$this->description = isset($data['description']) ? $data['description'] : null;
			$this->website = isset($data['website']) ? $data['website'] : null;
			$this->start = isset($data['start']) ? $data['start'] : null;
			$this->end = isset($data['end']) ? $data['end'] : null;
			$this->locationID = isset($data['locationID']) ? $data['locationID'] : null;
			$this->keywords = isset($data['keywords']) ? $data['keywords'] : null;
			$this->attendeeCount = isset($data['attendeeCount']) ? $data['attendeeCount'] : null;
			$this->image = isset($data['image']) ? $data['image'] : null;
		}
	}

	/* (non-PHPdoc)
	 * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
	 */
	public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter) {
		throw new \Exception('not used');
	}

	/* (non-PHPdoc)
	 * @see \Zend\InputFilter\InputFilterAwareInterface::getInputFilter()
	 */
	public function getInputFilter() {
		if(!$this->inputFilter) {
			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name'     => 'id',
				'required' => false,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'title',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'description',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'website',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'start',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'end',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'locationID',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'keywords',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'attendeeCount',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'image',
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