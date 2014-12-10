<?php

namespace Bootstrap\Form\View\Helper;

use Zend\Form\View\Helper\Form as ZfForm;
use Zend\Form\FieldsetInterface;
use Zend\Form\FormInterface;
use Zend\Form\ElementInterface;

/**
 *
 * @author AT21572
 *
 */
class Form extends ZfForm {

	/**
	 * (non-PHPdoc)
	 * @see \Zend\Form\View\Helper\Form::render()
	 */
	public function render(FormInterface $form) {
		if (method_exists($form, 'prepare')) {
			$form->prepare();
		}
		$formContent = '';
		foreach ( $form as $element ) {
			if ($element instanceof FieldsetInterface) {
				$formContent .= $this->getView()->formCollection($element);
			} else {
				$element->setOption('_form', $form);
				$formContent .= $this->getView()->formRow($element);
			}
		}
		return $this->openTag($form) . $formContent . $this->closeTag();
	}
}

?>