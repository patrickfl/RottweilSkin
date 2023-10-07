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
		parent::initPage( $out );
		$out->addModuleStyles( ['ext.bootstrap.styles'] );
	}

	/**
	 * @throws \MWException
	 */
	function addSkinModulesToOutput() {
		parent::addSkinModulesToOutput();
		$output = $this->getOutput();
		$output->addModules( ['skin.rottweil.styles'] );
	}

	protected function getLayoutFilePath() {
		global $IP;
		return "$IP/skins/RottweilSkin/layouts/rottweil-default.xml";
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
			$linkList[] = $linkRenderer->makeLink( $title, $displayName );
		}

		return implode( ' / ', $linkList );
	}
}
