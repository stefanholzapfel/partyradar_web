<?php

namespace Party\Form;

use Zend\Form\Form;

/**
 *
 * @author AT21572
 *
 */
class EventForm extends Form {

	public function __construct() {
		parent::__construct('event');

		$this->setAttribute('class', 'form-horizontal');

		$this->add(array(
			'name' => 'EventId',
			'type' => 'Hidden',
			'options' => array(
				'label' => 'EventId'
			),
		));

		$this->add(array(
			'name' => 'Title',
			'type' => 'Text',
			'options' => array(
				'label' => 'Title'
			),
			'attributes' => array(
				'id' => 'Title',
				'placeholder' => 'Title',
			),
		));

		$this->add(array(
			'name' => 'Description',
			'type' => 'TextArea',
			'options' => array(
				'label' => 'Description'
			),
			'attributes' => array(
				'id' => 'Description',
				'placeholder' => 'Description',
				'rows' => '10',
			),
		));

		$this->add(array(
			'name' => 'Website',
			'type' => 'Url',
			'options' => array(
				'label' => 'Website'
			),
			'attributes' => array(
				'id' => 'Website',
				'placeholder' => 'Website',
			),
		));

		$this->add(array(
			'name' => 'Start',
			'type' => 'Text',
			'options' => array(
				'label' => 'Start',
			),
			'attributes' => array(
				'id' => 'Start',
				'placeholder' => 'Start',
			),
		));

		$this->add(array(
			'name' => 'End',
			'type' => 'Text',
			'options' => array(
				'label' => 'End',
			),
			'attributes' => array(
				'id' => 'End',
				'placeholder' => 'End',
			),
		));

		$this->add(array(
			'name' => 'MaxAttends',
			'type' => 'Text',
			'options' => array(
				'label' => 'MaxAttends',
			),
			'attributes' => array(
				'id' => 'MaxAttends',
				'placeholder' => 'MaxAttends'
			),
		));

		$this->add(array(
			'name' => 'LocationId',
			'type' => 'Select',
			'options' => array(
				'label' => 'Location',
				'empty_option' => 'Please choose',
				'disable_inarray_validator' => true,
			),
			'attributes' => array(
				'id' => 'LocationId',
			),
		));

		$this->add(array(
			'name' => 'Keywords',
			'type' => 'Select',
			'options' => array(
				'label' => 'Keywords',
				'empty_option' => 'Please choose',
				'disable_inarray_validator' => true,
			),
			'attributes' => array(
				'id' => 'Keywords',
				'placeholder' => 'Keywords',
				'multiple' => true,
			),
		));

		$this->add(array(
			'name' => 'Image',
			'type' => 'File',
			'options' => array(
				'label' => 'Image'
			),
			'attributes' => array(
				'id' => 'Image',
				'placeholder' => 'Image'
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