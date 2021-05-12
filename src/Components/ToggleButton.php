<?php
namespace RottweilSkin\Components;

class ToggleButton extends \Skins\Chameleon\Components\Structure {

	/**
	 * The resulting HTML
	 * @return string
	 */
	public function getHtml() {
		$item = $this->getDomElement()->getAttribute( 'data-toggle' );
		$toggleClass = $this->getDomElement()->getAttribute( 'data-toggleClass' );

		$class = $this->getDomElement()->getAttribute( 'class' );

		$html = \Html::openElement( 'a', [
				'href' => '#',
				'class' => ' rw-toggle-button ' . $class,
				'data-toggle' => $item,
				'data-toggleClass' => $toggleClass,
				'role' => 'button'
			] );

		$html .= \Html::openElement( 'i', [ 'class' => $data ] );
		$html .= \Html::closeElement( 'i' );
		$html .= '';
		$html .= \Html::closeElement( 'a' );

		return $html;
	}
}
