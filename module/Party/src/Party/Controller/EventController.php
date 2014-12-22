<?php

namespace Party\Controller;


use Party\Form\EventForm;
use Party\Model\Event;
use Zend\Form\FormInterface;

class EventController extends AbstractActionController {

	public function indexAction() {
		$service = $this->getPartyRadarService();

		return array(
			'events' => $service->getEvents(),
		);
	}

	public function editAction() {
		$form = new EventForm();
		$id = (string)$this->params()->fromRoute('id', 0);
		if (! $id) {
			return $this->redirect()->toRoute('party/event', array(
				'action' => 'index',
			));
		}
		//try to fetch location object from service here...
		$event = new Event();

		$form->bind($event);

		return array(
			'form' => $form,
			'id' => $event->id,
			'name' => $event->title
		);
	}

	public function addAction() {
		$form = new EventForm();
		/* @var $request \Zend\Http\Request */
		$request = $this->getRequest();
		if($request->isPost()) {
			$event = new Event();
			$form->setInputFilter($event->getInputFilter());
			$form->setData($request->getPost());
			if ($form->isValid()) {
				$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
				$event->exchangeArray($data);
				//add location through service here --> DOES NOT WORK :-[[
				$this->flashMessenger()->addSuccessMessage("Event '" . $event->title . "' successfully created!");
				return $this->redirect()->toRoute('party/event', array('action' => 'index'));
			}
		}

		return array(
			'form' => $form,
		);
	}

}

?>