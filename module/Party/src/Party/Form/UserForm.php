<?php

namespace Party\Form;

use Zend\Form\Form;

class UserForm extends Form {

	public function __construct() {
		parent::__construct('user');

		$this->setAttribute('class', 'form-horizontal');

		$this->add(array(
			'name' => 'id',
			'type' => 'Hidden',
			'options' => array(
				'label' => 'id'
			),
		));

		$this->add(array(
			'name' => 'username',
			'type' => 'Text',
			'options' => array(
				'label' => 'Username'
			),
			'attributes' => array(
				'id' => 'username',
				'placeholder' => 'Username',
			),
		));

		$this->add(array(
			'name' => 'firstname',
			'type' => 'Text',
			'options' => array(
				'label' => 'Firstname'
			),
			'attributes' => array(
				'id' => 'firstname',
				'placeholder' => 'Firstname',
			),
		));

		$this->add(array(
			'name' => 'lastname',
			'type' => 'Text',
			'options' => array(
				'label' => 'Lastname'
			),
			'attributes' => array(
				'id' => 'lastname',
				'placeholder' => 'Lastname',
			),
		));

		$this->add(array(
			'name' => 'email',
			'type' => 'Email',
			'options' => array(
				'label' => 'Email'
			),
			'attributes' => array(
				'id' => 'email',
				'placeholder' => 'Email',
			),
		));

		$this->add(array(
			'name' => 'password',
			'type' => 'Password',
			'options' => array(
				'label' => 'Password'
			),
			'attributes' => array(
				'id' => 'password',
			),
		));

		$this->add(array(
			'name' => 'confirmPassword',
			'type' => 'Password',
			'options' => array(
				'label' => 'Password'
			),
			'attributes' => array(
				'id' => 'confirmPassword',
			),
		));

		$this->add(array(
			'name' => 'isAdmin',
			'type' => 'Checkbox',
			'options' => array(
				'label' => 'IsAdmin'
			),
			'attributes' => array(
				'id' => 'isAdmin',
			),
		));

		$this->add(array(
			'name' => 'submit',
			'type' => 'Submit',
			'options' => array(
				'label' => 'Submit',
			),
			'attributes' => array(
				'id' => 'submit',
				'value' => 'Submit',
				'class' => 'btn btn-primary'
			),
		));
	}
}

?>