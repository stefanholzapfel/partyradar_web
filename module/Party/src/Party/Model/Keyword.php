<?php

namespace Party\Model;

class Keyword {

	public $id;

	public $label;

	public function getArrayCopy() {
		$vars = array(
			'Id' => $this->id,
			'Label' => $this->label,
		);
		return $vars;
	}

	public function exchangeArray($data = array()) {
		if(count($data) > 0 && !is_null($data)) {
			$this->id = isset($data['Id']) ? $data['Id'] : null;
			$this->label = isset($data['Label']) ? $data['Label'] : null;
		}
	}

}

?>