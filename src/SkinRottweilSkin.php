<?php
/**
 *
 * @ingroup Skins
 */
class SkinRottweilSkin extends \Skins\Chameleon\Chameleon {
	public $skinname = 'rottweilskin';
	public $stylename = 'rottweilskin';
	public $template = '\SkinRottweilTemplate';
	public $useHeadElement = true;

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param $out OutputPage
	 */
	public function initPage( \OutputPage $out ) {
		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1.0' );
		//$out->addModules( array ( 'skin.rottweil.scripts' ) );
	}

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( \OutputPage $out ) {
		$out->addModuleStyles( array( 'skin.rottweil.styles' ) );
		parent::setupSkinUserCss( $out );
	}

	/**
	 * This will be called by OutputPage::headElement when it is creating the
	 * "<body>" tag, - adds output property bodyClassName to the existing classes
	 * @param OutputPage $out
	 * @param array $bodyAttrs
	 */
	public function addToBodyAttributes( $out, &$bodyAttrs ) {
	}

	protected function getLayoutFilePath() {
		global $IP;
		return "$IP/skins/RottweilSkin/layouts/rottweil-default.xml";
	}

	public function getDefaultModules() {
		$modules = parent::getDefaultModules();
		return $modules;
	}

	public function subPageSubtitle( $out = null ) {
		if( !$this->getTitle()->isSubpage() || 
		$this->getTitle()->getNamespace() == 10) {
			return '';
		}
		$parentTitle = $this->getTitle()->getBaseTitle();
		$ancestorTitles = [];
		while( $parentTitle->isSubpage() ) {
			$ancestorTitles[] = $parentTitle;
			$parentTitle = $parentTitle->getBaseTitle();
		}
		$ancestorTitles[] = $parentTitle;
		$ancestorTitles = array_reverse( $ancestorTitles );

		$linkList = [];
		$linkRenderer = \MediaWiki\MediaWikiServices::getInstance()->getLinkRenderer();
		foreach( $ancestorTitles as $title ) {
			$wikipage = \WikiPage::factory( $title );
			$parserOptions = $wikipage->makeParserOptions( $this->getContext() );
			$parserOutput = $wikipage->getParserOutput( $parserOptions );
			$displayName = '';
			if( $parserOutput ) {
				$displayName = $parserOutput->getTitleText();
			}
			//$displayName = $wikipage->getParserOutput( $parserOptions )->getTitleText();
			$linkList[] = $linkRenderer->makeLink( $title, $displayName );
		}

		return implode( ' / ', $linkList );
	}
}
