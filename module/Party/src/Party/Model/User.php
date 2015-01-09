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

	public $password;

	public $confirmPassword;

	/**
	 * @var \DateTime
	 */
	public $birthDate;

	public $gender;

	public function exchangeArray($data = array()) {
		if (count($data) > 0 && ! is_null($data)) {
			$this->id = isset($data['Id']) ? $data['Id'] : null;
			$this->userName = isset($data['UserName']) ? $data['UserName'] : null;
			$this->firstName = isset($data['FirstName']) ? $data['FirstName'] : null;
			$this->lastName = isset($data['LastName']) ? $data['LastName'] : null;
			$this->email = isset($data['Email']) ? $data['Email'] : null;
			$this->isAdmin = isset($data['IsAdmin']) ? $data['IsAdmin'] : false;
			$this->birthDate = isset($data['BirthDate']) ? new \DateTime($data['BirthDate']) : new \DateTime('31.12.9999');
			$this->gender = isset($data['Gender']) ? $data['Gender'] : null;
			$this->password = isset($data['Password']) ? $data['Password'] : null;
			$this->confirmPassword = isset($data['ConfirmPassword']) ? $data['ConfirmPassword'] : null;
		}
	}

	public function getArrayCopy() {
		$vars = array(
			'Id' => $this->id,
			'UserName' => $this->userName,
			'FirstName' => $this->firstName,
			'LastName' => $this->lastName,
			'Email' => $this->email,
			'IsAdmin' => $this->isAdmin,
			'BirthDate' => $this->birthDate->format('d.m.Y'),
			'Gender' => $this->gender
		);
		return $vars;
	}

	public function getServiceCopy() {
		$vars = $this->getServiceCopyForUpdate();
		$vars['Password'] = $this->password;
		$vars['ConfirmPassword'] = $this->confirmPassword;
		return $vars;
	}

	public function getServiceCopyForUpdate() {
		$vars = array(
			'UserName' => $this->userName,
			'FirstName' => $this->firstName,
			'LastName' => $this->lastName,
			'Email' => $this->email,
			'IsAdmin' => $this->isAdmin ? 'true' : 'false',
			'BirthDate' => $this->birthDate->format('Y-m-d'),
			'Gender' => $this->gender,
		);
		return $vars;
	}

	/*
	 * (non-PHPdoc)
	 * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
	 */
	public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter) {
		throw new \Exception('not used');
	}

	/**
	 * @return \Zend\InputFilter\InputFilter
	 */
	public function getUpdateInputFilter() {
		if (! $this->inputFilter) {
			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name' => 'FirstName',
				'required' => true,
				'filters' => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name' => 'LastName',
				'required' => true,
				'filters' => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name' => 'UserName',
				'required' => true,
				'filters' => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name' => 'Email',
				'required' => true,
				'filters' => self::$stdFilter,
				'validators' => array(
					array(
						'name' => 'EmailAddress'
					)
				)
			));

			$inputFilter->add(array(
				'name' => 'BirthDate',
				'required' => true,
				'filters' => self::$stdFilter,
				'validators' => array(
					array(
						'name' => 'Date',
						'options' => array(
							'locale' => 'de',
							'format' => 'd.m.Y',
						)
					)
				)
			));

			$inputFilter->add(array(
				'name' => 'Gender',
				'required' => true,
				'filters' => self::$stdFilter,
				'validators' => array(
					array(
						'name' => 'Between',
						'options' => array(
							'min' => 0,
							'max' => 2
						)
					)
				)
			));

			$inputFilter->add(array(
				'name' => 'IsAdmin',
				'required' => false,
				'filters' => array(
					array(
						'name' => 'Boolean',
					)
				)
			));

			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}

	/*
	 * (non-PHPdoc)
	 * @see \Zend\InputFilter\InputFilterAwareInterface::getInputFilter()
	 */
	public function getInputFilter() {
		$inputFilter = $this->getUpdateInputFilter();

		$inputFilter->add(array(
			'name' => 'Password',
			'required' => true,
			'filters' => self::$stdFilter,
			'validators' => array(
				new \Zend\Validator\Regex('((?=(.*\d){1,})(?=.*[A-Z]).{6,})')
			),
		));

		$inputFilter->add(array(
			'name' => 'ConfirmPassword',
			'required' => true,
			'filters' => self::$stdFilter,
			'validators' => array(
				array(
					'name' => 'Identical',
					'options' => array(
						'token' => 'Password'
					)
				)
			)
		));

		return $this->inputFilter;
  	}


}

?>
