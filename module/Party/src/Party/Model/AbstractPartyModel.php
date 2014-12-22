<?php

namespace Party\Model;

/**
 *
 * @author AT21572
 *
 */
class AbstractPartyModel {

	protected static $stdFilter = array(
		array('name' => 'StringTrim'),
		array('name' => 'StripTags'),
	);

	protected static $stdValidator = array(
		array(
			'name'    => 'StringLength',
			'options' => array(
				'encoding' => 'UTF-8',
				'min'      => 1,
				'max'      => 100,
			),
		),
	);

	protected $inputFilter;
}

?>