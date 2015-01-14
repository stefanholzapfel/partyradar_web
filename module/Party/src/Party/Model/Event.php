<?php

namespace Party\Model;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilter;

class Event extends AbstractPartyModel implements InputFilterAwareInterface {

	public $eventId;

	public $title;

	public $description;

	public $website;

	/**
	 * @var \DateTime
	 */
	public $start;

	/**
	 * @var \DateTime
	 */
	public $end;

	public $maxAttends;

	public $locationId;

	/**
	 * @var multitype:\Party\Model\Keyword
	 */
	public $keywords;

	public $attendeeCount;

	public $image;

	public function getArrayCopy() {
		$vars = array(
			'EventId' => $this->eventId,
			'Title' => $this->title,
			'Description' => $this->description,
			'Website' => $this->website,
			'Start' => $this->start->format('d.m.Y H:i'),
			'End' => $this->end->format('d.m.Y H:i'),
			'LocationId' => $this->locationId,
			'MaxAttends' => $this->maxAttends,
			'Keywords' => $this->keywords,
			'Image' => $this->image
		);
		return $vars;
	}

	public function getServiceCopy() {
		$vars = array(
			'Title' => $this->title,
			'Description' => $this->description,
			'Website' => $this->website ? $this->website : '',
			'Start' => $this->start->format('Y-m-d\TH:i'),
			'End' => $this->end->format('Y-m-d\TH:i'),
			'LocationId' => $this->locationId,
			'MaxAttends' => $this->maxAttends,
		);
		$image = $this->encodeImageToByteArray();
		if(!is_null($image))
			$vars['Image'] = $image;
		foreach ($this->keywords as $keyword) {
			$vars['KeywordIds'][] = $keyword->id;
		}
		return $vars;
	}

	public function getServiceCopyForUpdate() {
		return $this->getServiceCopy();
	}

	public function exchangeArray($data = array()) {
		if(count($data) > 0 && !is_null($data)) {
			$this->eventId = isset($data['EventId']) ? $data['EventId'] : null;
			$this->title = isset($data['Title']) ? $data['Title'] : null;
			$this->description = isset($data['Description']) ? $data['Description'] : null;
			$this->website = isset($data['Website']) ? $data['Website'] : null;
			$this->start = isset($data['Start']) ? new \DateTime($data['Start']) : new \DateTime('01.01.1970');
			$this->end = isset($data['End']) ? new \DateTime($data['End']) : new \DateTime('31.12.9999');
			$this->locationId = isset($data['LocationId']) ? $data['LocationId'] : null;
			$this->maxAttends = isset($data['MaxAttends']) ? $data['MaxAttends'] : null;
			if(isset($data['Keywords'])) {
				foreach ($data['Keywords'] as $keyword) {
					$keywordToAdd = new Keyword();
					$keywordToAdd->exchangeArray($keyword);
					$this->keywords[] = $keywordToAdd;
				}
			} else {
				$this->keywords = null;
			}
			$this->attendeeCount = isset($data['attendeeCount']) ? $data['attendeeCount'] : null;
			$this->image = isset($data['Image']) ? $data['Image'] : null;
		}
	}

	/**
	 * encodeImageToByteArray
	 *
	 * @return string|NULL
	 */
	protected function encodeImageToByteArray() {
		if(is_array($this->image) && $this->image['tmp_name']) {
			$file_tmp = $this->image['tmp_name'];
			$data = file_get_contents($file_tmp);
			$base64 = \Zend\Mime\Mime::encodeBase64($data);
			return $base64;
		} else {
			return null;
		}
	}

	/* (non-PHPdoc)
	 * @see \Zend\InputFilter\InputFilterAwareInterface::setInputFilter()
	 */
	public function setInputFilter(\Zend\InputFilter\InputFilterInterface $inputFilter) {
		throw new \Exception('not used');
	}

	/* (non-PHPdoc)
	 * @see \Zend\InputFilter\InputFilterAwareInterface::getInputFilter()
	 */
	public function getInputFilter() {
		if(!$this->inputFilter) {
			$inputFilter = new InputFilter();

			$inputFilter->add(array(
				'name'     => 'EventId',
				'required' => false,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'Title',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => self::$stdValidator
			));

			$inputFilter->add(array(
				'name'     => 'Description',
				'required' => true,
				'filters'  => self::$stdFilter,
			));

			$inputFilter->add(array(
				'name'     => 'Website',
				'required' => false,
				'filters'  => self::$stdFilter,
			));

			$inputFilter->add(array(
				'name'     => 'Start',
				'required' => true,
				'filters'  => self::$stdFilter,
				/*'validators' => array(
					array(
						'name' => 'DateTime',
						'options' => array(
							'locale' => 'de',
							'format' => 'd.m.Y H:i',
						)
					)
				)*/
			));

			$inputFilter->add(array(
				'name'     => 'End',
				'required' => true,
				'filters'  => self::$stdFilter,
				/*'validators' => array(
					array(
						'name' => 'DateTime',
						'options' => array(
							'locale' => 'de',
							'format' => 'd.m.Y H:i',
						)
					)
				)*/
			));

			$inputFilter->add(array(
				'name'     => 'MaxAttends',
				'required' => true,
				'filters'  => self::$stdFilter,
				'validators' => array(
					array(
						'name' => 'Digits'
					),
				),
			));

			$inputFilter->add(array(
				'name'     => 'LocationId',
				'required' => true,
			));

			$inputFilter->add(array(
				'name'     => 'Keywords',
				'required' => true,
			));

			$fileInput = new \Zend\InputFilter\FileInput('Image');
			$fileInput->setRequired(false);
			$fileInput->getValidatorChain()->attach(
				new \Zend\Validator\File\UploadFile()
			)->attach(
				new \Zend\Validator\File\IsImage()
			);
			$fileInput->getFilterChain()->attach(
				new \Zend\Filter\File\RenameUpload(array(
					'use_upload_name' => true,
					'overwrite' => true,
					'randomize' => true,
					'use_upload_extension' => true,
				))
			);
			$inputFilter->add($fileInput);

			/*$inputFilter->add(array(
				'name'     => 'Image',
				'required' => false,
				'filters'  => array(
					new \Zend\Filter\File\RenameUpload(array(
						'target' => './data/uploads/',
						'use_upload_name' => true,
						'overwrite' => true,
						'randomize' => true,
						'use_upload_extension' => true,
					))
				),
				'validators' => array(
					new \Zend\Validator\File\IsImage()
				),
			));*/

			$this->inputFilter = $inputFilter;
		}
		return $this->inputFilter;
	}

}

?>