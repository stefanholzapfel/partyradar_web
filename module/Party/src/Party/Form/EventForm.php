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
			'name' => 'id',
			'type' => 'Hidden',
			'options' => array(
				'label' => 'id'
			),
		));

		$this->add(array(
			'name' => 'title',
			'type' => 'Text',
			'options' => array(
				'label' => 'Title'
			),
			'attributes' => array(
				'id' => 'title',
				'placeholder' => 'Title',
			),
		));

		$this->add(array(
			'name' => 'description',
			'type' => 'Text',
			'options' => array(
				'label' => 'Description'
			),
			'attributes' => array(
				'id' => 'description',
				'placeholder' => 'Description',
			),
		));

		$this->add(array(
			'name' => 'website',
			'type' => 'Text',
			'options' => array(
				'label' => 'Website'
			),
			'attributes' => array(
				'id' => 'website',
				'placeholder' => 'Website',
			),
		));

		$this->add(array(
			'name' => 'start',
			'type' => 'Text',
			'options' => array(
				'label' => 'Start'
			),
			'attributes' => array(
				'id' => 'start',
				'placeholder' => 'Start',
			),
		));

		$this->add(array(
			'name' => 'end',
			'type' => 'Text',
			'options' => array(
				'label' => 'End'
			),
			'attributes' => array(
				'id' => 'end',
				'placeholder' => 'End',
			),
		));

		$this->add(array(
			'name' => 'locationID',
			'type' => 'Text',
			'options' => array(
				'label' => 'Location'
			),
			'attributes' => array(
				'id' => 'locationID',
				'placeholder' => 'Location',
			),
		));

		$this->add(array(
			'name' => 'keywords',
			'type' => 'Text',
			'options' => array(
				'label' => 'Keywords'
			),
			'attributes' => array(
				'id' => 'keywords',
				'placeholder' => 'Keywords',
			),
		));

		$this->add(array(
			'name' => 'attendeeCount',
			'type' => 'Bootstrap\Form\Element\StaticElement',
			'options' => array(
				'label' => 'Attendee count'
			),
			'attributes' => array(
				'id' => 'attendeeCount',
			),
		));

		$this->add(array(
			'name' => 'image',
			'type' => 'Text',
			'options' => array(
				'label' => 'Image'
			),
			'attributes' => array(
				'id' => 'image',
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