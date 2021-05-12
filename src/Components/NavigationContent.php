<?php
namespace RottweilSkin\Components;

class NavigationContent extends \Skins\Chameleon\Components\Structure {

	public function getHtml(){
		$class = $this->getDomElement()->getAttribute( 'class' );
		$class .= ' rw-navigation-content';

		$html = \Html::openElement(
				'div',
				array(
					'class' => $class
				)
			);

		$user = $this->getSkin()->getUser();
		$content_nav = $this->getSkinTemplate()->get('content_navigation');

		$html .= \Html::openElement( 'ul', [ 'class' => 'rw-namespaces' ] );

		if( true ){
			foreach( $content_nav['namespaces'] as $key => $value ){
				$html .= '<li><a id="' . $value['id'] . '" href="' . $value['href'] . '" title="' . $value['text'] . '" class="' . $value['class'] . '" >' . $value['text'] . '</a></li>';
			}
		}

		$html .= \Html::closeElement( 'ul' );

		$html .= \Html::openElement( 'ul', [ 'class' => 'rw-views' ] );

		if( true ){
			foreach( $content_nav['views'] as $key => $value ){
				$html .= '<li><a id="' . $value['id'] . '" href="' . $value['href'] . '" title="' . $value['text'] . '" class="' . $value['class'] . '" >' . $value['text'] . '</a></li>';
			}
		}

		$html .= \Html::closeElement( 'ul' );

		$html .= \Html::closeElement( 'div' );

		//$html .= parent::getHtml();

		return $html;
	}
}