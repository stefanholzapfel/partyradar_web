<?php

namespace Bootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormCheckbox as ZfFormCheckbox;
use Zend\Form\ElementInterface;
use Zend\Form\Element\Checkbox as CheckboxElement;
use Zend\Form\Exception;

/**
 *
 * @author AT21572
 *
 */
class FormCheckbox extends ZfFormCheckbox {

	public function render(ElementInterface $element)
	{
		if (!$element instanceof CheckboxElement) {
			throw new Exception\InvalidArgumentException(sprintf(
				'%s requires that the element is of type Zend\Form\Element\Checkbox',
				__METHOD__
			));
		}

		$name = $element->getName();
		if (empty($name) && $name !== 0) {
			throw new Exception\DomainException(sprintf(
				'%s requires that the element has an assigned name; none discovered',
				__METHOD__
			));
		}

		$attributes            = $element->getAttributes();
		$attributes['name']    = $name;
		$attributes['type']    = $this->getInputType();
		$attributes['value']   = $element->getCheckedValue();
		$closingBracket        = $this->getInlineClosingBracket();

		if ($element->isChecked()) {
			$attributes['checked'] = 'checked';
		}

		$rendered = sprintf(
			'<div class="checkbox"><label><input %s%s',
			$this->createAttributesString($attributes),
			$closingBracket . $element->getOption('checked_label') . '</label></div>'
		);

		if ($element->useHiddenElement()) {
			$hiddenAttributes = array(
				'name'  => $attributes['name'],
				'value' => $element->getUncheckedValue(),
			);

			$rendered = sprintf(
				'<input type="hidden" %s%s',
				$this->createAttributesString($hiddenAttributes),
				$closingBracket
			) . $rendered;
		}

		return $rendered;
	}
}

?>