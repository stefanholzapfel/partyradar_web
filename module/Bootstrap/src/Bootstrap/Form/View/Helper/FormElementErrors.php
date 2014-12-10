<?php

namespace Bootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormElementErrors as ZfFormElementErrors;
use Zend\Form\ElementInterface;

/**
 *
 * @author AT21572
 *
 */
class FormElementErrors extends ZfFormElementErrors {

	protected $wrap = '<span class="help-block">%s</span>';

	protected $messageCloseString = '';

	protected $messageOpenFormat = '';

	protected $messageSeparatorString = ',';

	/**
	 * (non-PHPdoc)
	 * @see \Zend\Form\View\Helper\FormElementErrors::__invoke()
	 */
	public function __invoke(ElementInterface $element = null, array $attributes = array()) {
		$errorHtml = parent::__invoke($element, $attributes);
		if ($errorHtml) {
			return sprintf($this->wrap, parent::__invoke($element, $attributes));
		}
		return null;
	}
}

?>