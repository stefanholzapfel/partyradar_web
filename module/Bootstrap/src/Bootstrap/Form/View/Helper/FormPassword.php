<?php

namespace Bootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormPassword as ZfFormPassword;
use Zend\Form\ElementInterface;

/**
 *
 * @author AT21572
 *
 */
class FormPassword extends ZfFormPassword {

	public function __invoke(ElementInterface $element = null)
	{
		if ($element) {
			$element->setValue('');
		}
		return parent::__invoke($element);
	}
}

?>