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
		if(is_array($data)) {
			$this->id = isset($data['Id']) ? $data['Id'] : null;
			$this->label = isset($data['Label']) ? $data['Label'] : null;
		} else {
			$this->exchangeArrayForEventUpdate($data);
		}
	}

	protected function exchangeArrayForEventUpdate($data) {
		$this->id = $data;
	}

}

?>