<?php

namespace Party\Form;

use Zend\Form\Form;

/**
 *
 * @author AT21572
 *
 */
class LocationForm extends Form {

	public function __construct() {
		parent::__construct('location');

		$this->setAttribute('class', 'form-horizontal');

		$this->add(array(
			'name' => 'Id',
			'type' => 'Hidden',
			'options' => array(
				'label' => 'Id'
			),
		));

		$this->add(array(
			'name' => 'Name',
			'type' => 'Text',
			'options' => array(
				'label' => 'Name'
			),
			'attributes' => array(
				'id' => 'Name',
				'placeholder' => 'Name',
			),
		));

		$this->add(array(
			'name' => 'Address',
			'type' => 'Text',
			'options' => array(
				'label' => 'Address'
			),
			'attributes' => array(
				'id' => 'Address',
				'placeholder' => 'Address',
			),
		));

		$this->add(array(
			'name' => 'AddressAdditions',
			'type' => 'Text',
			'options' => array(
				'label' => 'Address additions'
			),
			'attributes' => array(
				'id' => 'AddressAdditions',
				'placeholder' => 'Address additions',
			),
		));

		$this->add(array(
			'name' => 'ZipCode',
			'type' => 'Text',
			'options' => array(
				'label' => 'ZipCode'
			),
			'attributes' => array(
				'id' => 'ZipCode',
				'placeholder' => 'ZipCode',
			),
		));

		$this->add(array(
			'name' => 'City',
			'type' => 'Text',
			'options' => array(
				'label' => 'City'
			),
			'attributes' => array(
				'id' => 'City',
				'placeholder' => 'City',
			),
		));

		$this->add(array(
			'name' => 'Country',
			'type' => 'Text',
			'options' => array(
				'label' => 'Country'
			),
			'attributes' => array(
				'id' => 'Country',
				'placeholder' => 'Country',
			),
		));

		$this->add(array(
			'name' => 'Longitude',
			'type' => 'Text',
			'options' => array(
				'label' => 'Longitude'
			),
			'attributes' => array(
				'id' => 'Longitude',
				'placeholder' => 'Longitude',
			),
		));

		$this->add(array(
			'name' => 'Latitude',
			'type' => 'Text',
			'options' => array(
				'label' => 'Latitude'
			),
			'attributes' => array(
				'id' => 'Latitude',
				'placeholder' => 'Latitude',
			),
		));

		$this->add(array(
			'name' => 'MaxAttends',
			'type' => 'Text',
			'options' => array(
				'label' => 'Max attends'
			),
			'attributes' => array(
				'id' => 'MaxAttends',
				'placeholder' => 'Max attends',
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