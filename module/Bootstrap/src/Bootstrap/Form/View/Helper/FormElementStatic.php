<?php

namespace Bootstrap\Form\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\ElementInterface;

/**
 *
 * @author AT21572
 *
 */
class FormElementStatic extends AbstractHelper {

	private static $staticFormat = '<p class="form-control-static">%s</p>';

	private static $staticMultiValueList = '<ul class="form-control-static list-unstyled">%s</ul>';

	private static $staticMultiValueFormat = '<li>%s</li>';

	private static $hiddenElement = '<input type="hidden" name="%s" value="%s"/>';

	/**
	 * __invoke
	 *
	 * @param ElementInterface $element
	 * @return \Bootstrap\Form\View\Helper\FormElementStatic
	 */
	public function __invoke(ElementInterface $element = null) {
		if(!$element)
			return $this;

		return $this->render($element);
	}

	/**
	 * render
	 *
	 * @param ElementInterface $element
	 * @return string
	 */
	public function render(ElementInterface $element) {
		$hiddenElement = '';
		$content = '';
		if(is_array($element->getValue())) {
			$values = '';
			foreach ($element->getValue() as $value) {
				$values .= sprintf(self::$staticMultiValueFormat, $value);
				if($element->getOption('add_hidden_element')) {
					$hiddenElement .= sprintf(self::$hiddenElement,$element->getName() . '[]', $value);
				}
			}
			$content = sprintf(self::$staticMultiValueList, $values);
		} else {
			if($element->getOption('add_hidden_element')) {
				$hiddenElement = sprintf(self::$hiddenElement,$element->getName(), $element->getValue());
			}
			$content = sprintf(self::$staticFormat, $element->getValue());
		}
		return $content . $hiddenElement;
	}

}

?>