<?php

namespace Bootstrap\Form\View\Helper;

use Zend\Form\View\Helper\FormElement as ZfFormElement;
use Traversable;
use InvalidArgumentException;
use LogicException;
use Zend\Form\ElementInterface;
use Zend\Form\Element\Collection;
use Zend\Form\Factory;
use Zend\Form\Element\Button;
use Zend\Form\Element\Submit;
use Zend\Form\Element\Checkbox;

/**
 *
 * @author AT21572
 *
 */
class FormElement extends ZfFormElement {

	/**
	 *
	 * @var string
	 */
	protected static $addonFormat = '<%s class="%s">%s</%s>';

	/**
	 *
	 * @var string
	 */
	protected static $inputGroupFormat = '<div class="input-group %s">%s</div>';

	/**
	 * Instance map to view helper
	 *
	 * @var array
	 */
	protected $classMap = array(
		'Zend\Form\Element\Button' => 'formbutton',
		'Zend\Form\Element\Captcha' => 'formcaptcha',
		'Zend\Form\Element\Csrf' => 'formhidden',
		'Zend\Form\Element\Collection' => 'formcollection',
		'Zend\Form\Element\DateTimeSelect' => 'formdatetimeselect',
		'Zend\Form\Element\DateSelect' => 'formdateselect',
		'Zend\Form\Element\MonthSelect' => 'formmonthselect',
		'Bootstrap\Form\Element\StaticElement' => 'formStatic'
	);

	/**
	 * Render an element
	 *
	 * @param ElementInterface $oElement
	 * @return string
	 */
	public function render(ElementInterface $oElement) {
		// Add form-controll class
		$sElementType = $oElement->getAttribute('type');
		if (!($oElement instanceof Collection) && !($oElement instanceof Button) && !($oElement instanceof Submit) && !($oElement instanceof Checkbox)) {
			if ($sElementClass = $oElement->getAttribute('class')) {
				if (! preg_match('/(\s|^)form-control(\s|$)/', $sElementClass)) {
					$oElement->setAttribute('class', trim($sElementClass . ' form-control'));
				}
			} else {
				$oElement->setAttribute('class', 'form-control');
			}
		}

		$sMarkup = parent::render($oElement);

		// Addon prepend
		if ($aAddOnPrepend = $oElement->getOption('add-on-prepend')) {
			$sMarkup = $this->renderAddOn($aAddOnPrepend) . $sMarkup;
		}

		// Addon append
		if ($aAddOnAppend = $oElement->getOption('add-on-append')) {
			$sMarkup .= $this->renderAddOn($aAddOnAppend);
		}

		if ($aAddOnAppend || $aAddOnPrepend) {
			$sSpecialClass = '';
			// Input size
			if ($sElementClass = $oElement->getAttribute('class')) {
				if (preg_match('/(\s|^)input-lg(\s|$)/', $sElementClass)) {
					$sSpecialClass .= ' input-group-lg';
				} elseif (preg_match('/(\s|^)input-sm(\s|$)/', $sElementClass)) {
					$sSpecialClass .= ' input-group-sm';
				}
			}
			return sprintf(self::$inputGroupFormat, trim($sSpecialClass), $sMarkup);
		}
		return $sMarkup;
	}

	/**
	 * Render addo-on markup
	 *
	 * @param string $aAddOnOptions
	 * @throws InvalidArgumentException
	 * @throws LogicException
	 * @return string
	 */
	protected function renderAddOn($aAddOnOptions) {
		if (empty($aAddOnOptions)) {
			throw new InvalidArgumentException('Addon options are empty');
		}
		if ($aAddOnOptions instanceof ElementInterface) {
			$aAddOnOptions = array(
				'element' => $aAddOnOptions
			);
		} elseif (is_scalar($aAddOnOptions)) {
			$aAddOnOptions = array(
				'text' => $aAddOnOptions
			);
		} elseif (! is_array($aAddOnOptions)) {
			throw new InvalidArgumentException(sprintf('Addon options expects an array or a scalar value, "%s" given', is_object($aAddOnOptions) ? get_class($aAddOnOptions) : gettype($aAddOnOptions)));
		}

		$sMarkup = '';
		$sAddonTagName = 'span';
		$sAddonClass = '';
		if (! empty($aAddOnOptions['text'])) {
			if (! is_scalar($aAddOnOptions['text'])) {
				throw new InvalidArgumentException(sprintf('"text" option expects a scalar value, "%s" given', is_object($aAddOnOptions['text']) ? get_class($aAddOnOptions['text']) : gettype($aAddOnOptions['text'])));
			} elseif (($oTranslator = $this->getTranslator())) {
				$sMarkup .= $oTranslator->translate($aAddOnOptions['text'], $this->getTranslatorTextDomain());
			} else {
				$sMarkup .= $aAddOnOptions['text'];
			}
			$sAddonClass .= ' input-group-addon';
		} elseif (! empty($aAddOnOptions['element'])) {
			if (is_array($aAddOnOptions['element']) || ($aAddOnOptions['element'] instanceof Traversable && ! ($aAddOnOptions['element'] instanceof ElementInterface))) {
				$oFactory = new Factory();
				$aAddOnOptions['element'] = $oFactory->create($aAddOnOptions['element']);
			} elseif (! ($aAddOnOptions['element'] instanceof ElementInterface)) {
				throw new LogicException(sprintf('"element" option expects an instanceof Zend\Form\ElementInterface, "%s" given', is_object($aAddOnOptions['element']) ? get_class($aAddOnOptions['element']) : gettype($aAddOnOptions['element'])));
			}

			$aAddOnOptions['element']->setOptions(array_merge($aAddOnOptions['element']->getOptions(), array(
				'disable-twb' => true
			)));

			$sMarkup .= $this->render($aAddOnOptions['element']);

			if ($aAddOnOptions['element'] instanceof Button) {
				$sAddonClass .= ' input-group-btn';
				// Element contains dropdown, so add-on container must be a "div"
				if ($aAddOnOptions['element']->getOption('dropdown')) {
					$sAddonTagName = 'div';
				}
			} else {
				$sAddonClass .= ' input-group-addon';
			}
		}

		return sprintf(self::$addonFormat, $sAddonTagName, trim($sAddonClass), $sMarkup, $sAddonTagName);
	}
}

?>