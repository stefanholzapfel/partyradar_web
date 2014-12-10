<?php

namespace Bootstrap\View\Helper;

use Zend\View\Helper\Navigation\Menu;
use RecursiveIteratorIterator;
use Zend\Navigation\AbstractContainer;
use Zend\Navigation\Page\AbstractPage;

/**
 *
 * @author AT21572
 *
 */
class BootstrapMenu extends Menu {

	/*
	 * (non-PHPdoc)
	 * @see \Zend\View\Helper\Navigation\Menu::htmlify()
	 */
	public function htmlify(\Zend\Navigation\Page\AbstractPage $page, $escapeLabel = true, $addClassToListItem = false, $caret = false) {
		// get attribs for element
		$attribs = array(
			'id' => $page->getId(),
			'title' => $this->translate($page->getTitle(), $page->getTextDomain())
		);

		// add additional attributes
		$attr = $page->get('attribs');
		if(is_array($attr)){
			$attribs = $attribs + $attr;
		}

		// does page have a href?
		$href = $page->getHref();
		if ($href) {
			$element = 'a';
			$attribs['href'] = $href;
			$attribs['target'] = $page->getTarget();
		} else {
			$element = 'span';
		}

		$html = '<' . $element . $this->htmlAttribs($attribs) . '>';
		$label = $this->translate($page->getLabel(), $page->getTextDomain());
		if ($escapeLabel === true) {
			/**
			 *
			 * @var \Zend\View\Helper\EscapeHtml $escaper
			 */
			$escaper = $this->view->plugin('escapeHtml');
			$html .= $escaper($label);
		} else {
			$html .= $label;
		}

		if($caret) {
			$html .= '<b class="caret"></b>';
		}

		$html .= '</' . $element . '>';

		return $html;
	}

	/*
	 * (non-PHPdoc)
	 * @see \Zend\View\Helper\Navigation\Menu::renderNormalMenu()
	 */
	protected function renderNormalMenu(\Zend\Navigation\AbstractContainer $container, $ulClass, $indent, $minDepth, $maxDepth, $onlyActive, $escapeLabels, $addClassToListItem, $liActiveClass) {
		$html = '';

		// find deepest active
		$found = $this->findActive($container, $minDepth, $maxDepth);
		/* @var $escaper \Zend\View\Helper\EscapeHtmlAttr */
		$escaper = $this->view->plugin('escapeHtmlAttr');

		if ($found) {
			$foundPage = $found['page'];
			$foundDepth = $found['depth'];
		} else {
			$foundPage = null;
		}

		// create iterator
		$iterator = new RecursiveIteratorIterator($container, RecursiveIteratorIterator::SELF_FIRST);
		if (is_int($maxDepth)) {
			$iterator->setMaxDepth($maxDepth);
		}

		// iterate container
		$prevDepth = - 1;
		foreach ( $iterator as $page ) {
			$depth = $iterator->getDepth();
			$isActive = $page->isActive(true);
			if ($depth < $minDepth || ! $this->accept($page)) {
				// page is below minDepth or not accepted by acl/visibility
				continue;
			} elseif ($onlyActive && ! $isActive) {
				// page is not active itself, but might be in the active branch
				$accept = false;
				if ($foundPage) {
					if ($foundPage->hasPage($page)) {
						// accept if page is a direct child of the active page
						$accept = true;
					} elseif ($foundPage->getParent()->hasPage($page)) {
						// page is a sibling of the active page...
						if (! $foundPage->hasPages(! $this->renderInvisible) || is_int($maxDepth) && $foundDepth + 1 > $maxDepth) {
							// accept if active page has no children, or the
							// children are too deep to be rendered
							$accept = true;
						}
					}
				}

				if (! $accept) {
					continue;
				}
			}

			// make sure indentation is correct
			$depth -= $minDepth;
			$myIndent = $indent . str_repeat('        ', $depth);

			if ($depth > $prevDepth) {
				// start new ul tag
				if ($ulClass && $depth == 0) {
					$ulClass = ' class="' . $escaper($ulClass) . '"';
				} elseif($ulClass = $page->get('pagesContainerClass')) {
        			$ulClass = ' class="' . $ulClass . '"';
				} else {
					$ulClass = '';
				}
				$html .= $myIndent . '<ul' . $ulClass . '>' . PHP_EOL;
			} elseif ($prevDepth > $depth) {
				// close li/ul tags until we're at current depth
				for($i = $prevDepth; $i > $depth; $i --) {
					$ind = $indent . str_repeat('        ', $i);
					$html .= $ind . '    </li>' . PHP_EOL;
					$html .= $ind . '</ul>' . PHP_EOL;
				}
				// close previous li tag
				$html .= $myIndent . '    </li>' . PHP_EOL;
			} else {
				// close previous li tag
				$html .= $myIndent . '    </li>' . PHP_EOL;
			}

			// render li tag and page
			$liClasses = array();
			// Is page active?
			if ($isActive) {
				$liClasses[] = 'active';
			}

			if($wrapClass = $page->get('wrapClass')){
				$liClasses[] = $wrapClass;
			}

			$liClass = empty($liClasses) ? '' : ' class="' . $escaper(implode(' ', $liClasses)) . '"';

			$html .= $myIndent . '    <li' . $liClass . '>' . PHP_EOL . $myIndent . '        ' . $this->htmlify($page, $escapeLabels, $addClassToListItem, $page->get('caret')) . PHP_EOL;

			// store as previous depth for next iteration
			$prevDepth = $depth;
		}

		if ($html) {
			// done iterating container; close open ul/li tags
			for($i = $prevDepth + 1; $i > 0; $i --) {
				$myIndent = $indent . str_repeat('        ', $i - 1);
				$html .= $myIndent . '    </li>' . PHP_EOL . $myIndent . '</ul>' . PHP_EOL;
			}
			$html = rtrim($html, PHP_EOL);
		}

		return $html;
	}
}

?>