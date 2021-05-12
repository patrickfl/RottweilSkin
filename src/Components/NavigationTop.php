<?php
namespace RottweilSkin\Components;

class NavigationTop extends \Skins\Chameleon\Components\Structure {

	public function getHtml(){
		$class = $this->getDomElement()->getAttribute( 'class' );
		$class .= ' rw-navigation-top';

		$html = \Html::openElement(
				'div',
				array(
					'class' => $class
				)
			);

		$user = $this->getSkin()->getUser();
		$p_tools = $this->getSkinTemplate()->getPersonalTools();

		$html .= \Html::openElement( 'ul' );

		if( !$user->isLoggedIn() ){
			foreach( $p_tools as $key => $value ){
				if( $key === 'createaccount' || $key === 'login' ){
					$html .= '<li><a id="' . $value['id'] . '" href="' . $value['links'][0]['href'] . '" title="' . $value['links'][0]['text'] . '">' . $value['links'][0]['text'] . '</a></li>';
				}
			}
		}
		else{
			foreach( $p_tools as $key => $value ){
				$html .= '<li><a id="' . $value['id'] . '" href="' . $value['links'][0]['href'] . '" title="' . $value['links'][0]['text'] . '">' . $value['links'][0]['text'] . '</a></li>';
			}
		}

		$html .= \Html::closeElement( 'ul' );
		#var_dump($this->getSkinTemplate()->getPersonalTools());
		#var_dump($this->getSkinTemplate()->getToolbox());
		#var_dump($this->getSkinTemplate()->get('content_navigation'));
		#var_dump($this->getSkinTemplate()->get('nav_urls'));

		$html .= \Html::closeElement( 'div' );

		$html .= parent::getHtml();

		return $html;
	}
}