<?php

namespace Party\Form;

class UserForm extends AbstractPartyForm {

	public function __construct($mode) {
		parent::__construct('user');

		$this->setAttribute('class', 'form-horizontal');

		$this->add(array(
			'name' => 'Id',
			'type' => 'Hidden',
			'options' => array(
				'label' => 'Id'
			),
		));

		$this->add(array(
			'name' => 'UserName',
			'type' => 'Text',
			'options' => array(
				'label' => 'Username'
			),
			'attributes' => array(
				'id' => 'UserName',
				'placeholder' => 'Username',
			),
		));

		$this->add(array(
			'name' => 'FirstName',
			'type' => 'Text',
			'options' => array(
				'label' => 'Firstname'
			),
			'attributes' => array(
				'id' => 'FirstName',
				'placeholder' => 'Firstname',
			),
		));

		$this->add(array(
			'name' => 'LastName',
			'type' => 'Text',
			'options' => array(
				'label' => 'Lastname'
			),
			'attributes' => array(
				'id' => 'LastName',
				'placeholder' => 'Lastname',
			),
		));

		$this->add(array(
			'name' => 'Email',
			'type' => 'Email',
			'options' => array(
				'label' => 'Email'
			),
			'attributes' => array(
				'id' => 'Email',
				'placeholder' => 'Email',
			),
		));

		$this->add(array(
			'name' => 'BirthDate',
			'type' => 'Date',
			'options' => array(
				'label' => 'Birthdate',
				'format' => 'd.m.Y'
			),
			'attributes' => array(
				'id' => 'BirthDate',
				'placeholder' => 'BirthDate',
			),
		));

		$this->add(array(
			'name' => 'Gender',
			'type' => 'Select',
			'options' => array(
				'label' => 'Gender',
				'empty_option' => 'Please choose',
				'value_options' => array(
					0 => 'Unknown',
					1 => 'Male',
					2 => 'Female'
				),
			),
			'attributes' => array(
				'id' => 'Gender',
			),
		));

		if($mode == AbstractPartyForm::MODE_ADD) {
			$this->add(array(
				'name' => 'Password',
				'type' => 'Password',
				'options' => array(
					'label' => 'Password'
				),
				'attributes' => array(
					'id' => 'Password',
				),
			));

			$this->add(array(
				'name' => 'ConfirmPassword',
				'type' => 'Password',
				'options' => array(
					'label' => 'Confirm password'
				),
				'attributes' => array(
					'id' => 'ConfirmPassword',
				),
			));
		}

		$this->add(array(
			'name' => 'IsAdmin',
			'type' => 'Checkbox',
			'options' => array(
				'label' => 'IsAdmin',
				'use_hidden_element' => true,
				'checked_value' => 1,
				'unchecked_value' => 0,
				'disable_inarray_validator' => true,
			),
			'attributes' => array(
				'id' => 'IsAdmin',
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