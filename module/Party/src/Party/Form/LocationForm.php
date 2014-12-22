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
			'name' => 'id',
			'type' => 'Hidden',
			'options' => array(
				'label' => 'id'
			),
		));

		$this->add(array(
			'name' => 'locationName',
			'type' => 'Text',
			'options' => array(
				'label' => 'Name'
			),
			'attributes' => array(
				'id' => 'locationName',
				'placeholder' => 'Name',
			),
		));

		$this->add(array(
			'name' => 'lon',
			'type' => 'Text',
			'options' => array(
				'label' => 'Longitude'
			),
			'attributes' => array(
				'id' => 'lon',
				'placeholder' => 'Longitude',
			),
		));

		$this->add(array(
			'name' => 'lat',
			'type' => 'Text',
			'options' => array(
				'label' => 'Latitude'
			),
			'attributes' => array(
				'id' => 'lat',
				'placeholder' => 'Latitude',
			),
		));

		$this->add(array(
			'name' => 'address',
			'type' => 'Text',
			'options' => array(
				'label' => 'Address'
			),
			'attributes' => array(
				'id' => 'address',
				'placeholder' => 'Address',
			),
		));

		$this->add(array(
			'name' => 'addressAdditions',
			'type' => 'Text',
			'options' => array(
				'label' => 'Address additions'
			),
			'attributes' => array(
				'id' => 'addressAdditions',
				'placeholder' => 'Address additions',
			),
		));

		$this->add(array(
			'name' => 'zipcode',
			'type' => 'Text',
			'options' => array(
				'label' => 'Zipcode'
			),
			'attributes' => array(
				'id' => 'zipcode',
				'placeholder' => 'Zipcode',
			),
		));

		$this->add(array(
			'name' => 'country',
			'type' => 'Text',
			'options' => array(
				'label' => 'Country'
			),
			'attributes' => array(
				'id' => 'country',
				'placeholder' => 'Country',
			),
		));

		$this->add(array(
			'name' => 'maxAttends',
			'type' => 'Text',
			'options' => array(
				'label' => 'Max attends'
			),
			'attributes' => array(
				'id' => 'maxAttends',
				'placeholder' => 'Max attends',
			),
		));

		$this->add(array(
			'name' => 'isInactive',
			'type' => 'Checkbox',
			'options' => array(
				'label' => 'Is Inactive'
			),
			'attributes' => array(
				'id' => 'isInactive',
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