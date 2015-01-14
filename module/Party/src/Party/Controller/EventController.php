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
		$id = (string)$this->params()->fromRoute('id', 0);
		if (! $id) {
			return $this->redirect()->toRoute('party/event', array(
				'action' => 'index',
			));
		}
		$form = new EventForm();
		/* @var $request \Zend\Http\Request */
		$request = $this->getRequest();
		if($request->isPost()) {
			$post = array_merge_recursive(
				$request->getPost()->toArray(),
				$request->getFiles()->toArray()
			);
			$event = new Event();
			$form->setInputFilter($event->getInputFilter());
			$form->setData($post);
			if ($form->isValid()) {
				$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
				$event->exchangeArray($data);
				try {
					$this->getPartyRadarService()->updateEvent($event);
				} catch (\Exception $e) {
					$this->flashMessenger()->addErrorMessage($e->getMessage());
					return $this->redirect()->toRoute('party/event', array(
						'action' => 'edit'
					));
				}

				$this->flashMessenger()->addSuccessMessage("Event '" . $event->title . "' successfully updated!");
				return $this->redirect()->toRoute('party/event', array(
					'action' => 'index'
				));
			}
		}
		try {
			$event = $this->getPartyRadarService()->getEvent($id);
		} catch (\Exception $e) {
			$this->flashMessenger()->addErrorMessage($e->getMessage());
			return $this->redirect()->toRoute('party/event', array(
				'action' => 'index'
			));
		}


		/* @var $locationSelect \Zend\Form\Element\Select */
		$locationSelect = $form->get('LocationId');
		$locationSelect->setValueOptions($this->getLocationOptions());
		/* @var $keywordSelect \Zend\Form\Element\Select */
		$keywordSelect = $form->get('Keywords');
		$keywordSelect->setValueOptions($this->getKeywordOptions($event));


		$form->bind($event);


		return array(
			'form' => $form,
			'id' => $event->eventId,
			'name' => $event->title,
		);
	}

	public function addAction() {
		$form = new EventForm();
		/* @var $request \Zend\Http\Request */
		$request = $this->getRequest();
		if($request->isPost()) {
			$event = new Event();
			$form->setInputFilter($event->getInputFilter());
			$post = array_merge_recursive(
				$request->getPost()->toArray(),
				$request->getFiles()->toArray()
			);
			$form->setData($post);
			if ($form->isValid()) {
				$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
				$event->exchangeArray($data);
				try {
					$this->getPartyRadarService()->addEvent($event);
				} catch (\Exception $e) {
					$this->flashMessenger()->addErrorMessage($e->getMessage());
					return $this->redirect()->toRoute('party/event', array(
						'action' => 'add',
					));
				}
				$this->flashMessenger()->addSuccessMessage("Event '" . $event->title . "' successfully created!");
				return $this->redirect()->toRoute('party/event', array(
					'action' => 'index'
				));
			}
		}
		/* @var $locationSelect \Zend\Form\Element\Select */
		$locationSelect = $form->get('LocationId');
		$locationSelect->setValueOptions($this->getLocationOptions());
		/* @var $keywordSelect \Zend\Form\Element\Select */
		$keywordSelect = $form->get('Keywords');
		$keywordSelect->setValueOptions($this->getKeywordOptions());

		return array(
			'form' => $form,
		);
	}

	public function deleteAction() {
		$id = (string)$this->params()->fromRoute('id', 0);
		if (! $id) {
			return $this->redirect()->toRoute('party/event', array(
				'action' => 'index',
			));
		}
		try {
			$this->getPartyRadarService()->deleteEvent($id);
		} catch (\Exception $e) {
			$this->flashMessenger()->addErrorMessage($e->getMessage());
			return $this->redirect()->toRoute('party/event', array(
				'action' => 'index',
			));
		}

		$this->flashMessenger()->addSuccessMessage("Event successfully deleted!");
		return $this->redirect()->toRoute('party/event', array(
			'action' => 'index',
		));
	}

	/**
	 * @param Event $event (optional)
	 * @return array keywordOptions
	 */
	protected function getKeywordOptions(Event $event = NULL) {
		$keywords = $this->getPartyRadarService()->getKeywords();
		foreach ($keywords as $keyword) {
			$selected = FALSE;
			if(!is_null($event) && count($event->keywords) > 0 && in_array($keyword, $event->keywords)) {
				$selected = TRUE;
			}
			$return[] = array(
				'value' => $keyword->id,
				'label' => $keyword->label,
				'selected' => $selected
			);
		}
		return $return;
	}

	/**
	 * @return array locationOptions
	 */
	protected function getLocationOptions() {
		$locations = $this->getPartyRadarService()->getLocations();
		foreach ($locations as $location) {
			$return[$location->id] = $location->name;
		}
		return $return;
	}

}

?>