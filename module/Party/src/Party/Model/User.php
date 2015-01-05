<?php

namespace Party\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;

class User extends AbstractPartyModel implements InputFilterAwareInterface {

	public $id;

	public $userName;

	public $firstName;

	public $lastName;

	public $email;

	public $isAdmin;


	public function exchangeArray($data = array()) {
		if(count($data) > 0 && !is_null($data)) {
			$this->id= isset($data['Id']) ? $data['Id'] : null;
			$this->userName = isset($data['UserName']) ? $data['UserName'] : null;
			$this->firstName = isset($data['FirstName']) ? $data['FirstName'] : null;
			$this->lastName = isset($data['LastName']) ? $data['LastName'] : null;
			$this->email = isset($data['Email']) ? $data['Email'] : null;
			$this->isAdmin = isset($data['IsAdmin']) ? boolval($data['IsAdmin']) : null;
		}
	}

	public function getArrayCopy() {
		return get_object_vars($this);
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
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name'     => 'firstname',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'lastname',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'username',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'email',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => array(
					array(
						'name'    => 'EmailAddress',
					),
				),
			));

			$inputFilter->add(array(
				'name'     => 'password',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'confirmPassword',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'isAdmin',
				'required' => true,
			));

			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}


}

?>