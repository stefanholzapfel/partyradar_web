<?php

namespace Party\Controller;


class EventController extends AbstractActionController {

	public function indexAction() {
		$service = $this->getPartyRadarService();

		return array(
			'events' => $service->getEvents(),
		);
	}

}

?>