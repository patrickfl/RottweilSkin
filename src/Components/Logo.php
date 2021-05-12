<?php
namespace RottweilSkin\Components;

class Logo extends \Skins\Chameleon\Components\Structure {

	public function getHtml(){
		global $wgScriptPath;

		$html = \Html::openElement(
				'a',
				array(
					'href' => $this->getSkin()->getConfig()->get( 'Server' ) . $this->getSkin()->getConfig()->get( 'ScriptPath' ),
					'class' => 'rw-banner'
				)
			);

		$html .= \Html::openElement(
				'img',
				array(
					'src' => $wgScriptPath . "/skins/RottweilSkin/resources/images/titelleiste.jpg"
				)
			);
		$html .= \Html::closeElement( 'img' );

		$html .= \Html::closeElement( 'a' );

		$html .= parent::getHtml();

		return $html;
	}
}