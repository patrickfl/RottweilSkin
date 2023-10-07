<?php
namespace RottweilSkin\Components;

class Aside extends \Skins\Chameleon\Components\Structure {

	public function getHtml(){

		$classes = $this->getDomElement()->getAttribute( 'class' );
		$classes .= '';

		$nav = '<ul class="nav-body">';
		$nav .= $this->makeSectionNavigation();
		$nav .= $this->makeSectionInteractiveLinks();
		$nav .= $this->makeSectionSubpages();
		$nav .= $this->makeSectionExternalLinks();
		$nav .= $this->makeSectionCurrentLinks();
		$nav .= $this->makeSectionToolbox();
		$nav .= '</ul>';
		return $nav;

	}

	protected function makeSectionNavigation() {
		/*
		 * Startseite
		 * "Nach oben"
		 * Verein Rottweiler Bilder e.V.
		 * Suchen
		 * Archiv
		 * Instagran
		 * Impressum
		 * Datenschutz
		 */
		$items = [];

		$title = \Title::newFromText( wfMessage( 'mainpage' )->plain() );
		$items[] = [
			'href' => $title->getFullURL(),
			'title' => $title->getFullText(),
			'text' => $title->getFullText(),
			'iconClass' => 'rw-icon-mainpage'
		];

		$title = $this->getSkin()->getTitle();
		$user = $this->getSkin()->getUser();
		$userCanEdit = \MediaWiki\MediaWikiServices::getInstance()->getPermissionManager()->userCan( 'edit', $user, $title );
		if( ( !$title->isSpecialPage() ) && $userCanEdit ){
			$items[] = [
				'href' => $title->getEditURL(),
				'title' => wfMessage( 'rottweil-navigation-main-editor-title' )->plain(),
				'text' => wfMessage( 'rottweil-navigation-main-editor-text' )->plain(),
				'iconClass' => 'rw-icon-editor'
			];
		}

		$base = $this->getSkin()->getTitle()->getBaseTitle();
		if( !$title->equals( $base ) ){
			$items[] = [
				'href' => $base->getFullURL(),
				'title' => wfMessage( 'rottweil-navigation-main-page-up-title' )->plain(),
				'text' => wfMessage( 'rottweil-navigation-main-page-up-text' )->plain(),
				'iconClass' => 'rw-icon-page-up'
			];
		}

		$title = \Title::newFromText( wfMessage( 'rottweil-verein-page' )->plain() );
		$items[] = [
			'href' => $title->getFullURL(),
			'title' => wfMessage( 'rottweil-verein' )->plain(),
			'text' => wfMessage( 'rottweil-verein' )->plain(),
			'iconClass' => 'rw-icon-nonprofit'
		];

		$title = \Title::makeTitle( NS_SPECIAL, 'Search');
		$items[] = [
			'href' => $title->getFullURL(),
			'title' => wfMessage( 'search' )->plain(),
			'text' => wfMessage( 'search' )->plain(),
			'iconClass' => 'rw-icon-search'
		];

		$title = \Title::newFromText( wfMessage( 'rottweil-navigation-main-archive' )->plain() );
		$items[] = [
			'href' => 'https://archive.rottweil.net', //'$title->getFullURL(),
			'title' => $title->getFullText(),
			'text' => $title->getFullText(),
			'iconClass' => 'rw-icon-archive'
		];		

		$title = \Title::newFromText( wfMessage( 'rottweil-navigation-main-instagram' )->plain() );
		$items[] = [
			'href' => 'https://www.instagram.com/rottweiler_bilder/', //'$title->getFullURL(),
			'title' => $title->getFullText(),
			'text' => $title->getFullText(),
			'iconClass' => 'rw-icon-instagram'
		];		

		$title = \Title::newFromText( wfMessage( 'rottweil-navigation-main-impressum' )->plain() );
		$items[] = [
			'href' => $title->getFullURL(),
			'title' => $title->getFullText(),
			'text' => $title->getFullText(),
			'iconClass' => 'rw-icon-impressum'
		];

		$title = \Title::newFromText( wfMessage( 'privacypage' )->plain() );
		$items[] = [
			'href' => $title->getFullURL(),
			'title' => wfMessage( 'privacy' )->plain(),
			'text' => wfMessage( 'privacy' )->plain(),
			'iconClass' => 'rw-icon-privacy'
		];


		if( empty( $items ) ){
			return '';
		}

		$html = '<li><span class="nav-heading">' . wfMessage( 'rottweil-navigation-main' ) . '</span></li>';

		foreach( $items as $item ){
			$html .= '<li><a href="' . $item['href'] .'" title="' . $item['title'] . '" ><span class="rw-icon ' . $item['iconClass'] . '"></span><span class="rw-text">' . $item['text'] . '</span></a></li>';;
		}

		return $html;
	}

	protected function makeSectionInteractiveLinks() {
		if( $this->getSkin()->getTitle()->isMainPage() ) {
			return '';
		}

		$html = '<li><span class="nav-heading">' . wfMessage( 'rottweil-navigation-interactive' ) . '</span></li>';

		$html .= '<li><a href="http://www.guestbook-free.com/books3/nlh/"><span class="rw-icon rw-icon-star"></span><span class="rw-text">' . wfMessage( 'rottweil-navigation-guestbook' ) . '</span></a></li>';

		return $html;
	}

	protected function makeSectionSubpages() {
		$currentTitle = $this->getSkin()->getTitle();


		if( $currentTitle->isMainPage() ) {
			$subpages = $this->getRootPages();
		}
		else {
			$subpages = [];
			$allSubpages = $currentTitle->getSubpages();
			/**
			 * @var \Title $subpage
			 */
			foreach ( $allSubpages as $subpage ) {
				$subpage instanceof \Title;

				if( !$subpage->getBaseTitle()->equals( $currentTitle ) ) {
					continue;
				}

				$subpages[] = $subpage;
			}
		}

		$sortedSubpages = [];

		/**
		 * @var \Title $subpage
		 */
		foreach ( $subpages as $subpage ) {
			$wikipage = \WikiPage::factory( $subpage );
			$parserOptions = $wikipage->makeParserOptions( $this->getSkin()->getContext() );
			$parserOutput = $article->getParserOutput( $parserOptions );

			$defaultsort = [];
			if ( method_exists( $parserOutput, 'getPageProperty' ) ) {
				$defaultsort = $wikipage->getParserOutput( $parserOptions )->getPageProperty( 'defaultsort' );
			} else {
				$defaultsort = $wikipage->getParserOutput( $parserOptions )->getProperty( 'defaultsort' );
			}

			if ( !$defaultsort ){
				continue;
			}

			$count = 0;
			$label = $this->makeLinkLabelFromDefaultSort( $defaultsort );
			while( isset( $sortedSubpages[$defaultsort] ) ){
				$count++;
				$defaultsort = $label . " ($count)";
			}
			$sortedSubpages[ $defaultsort ] = [
				'label' => $label,
				'title' => $subpage
			];
		}

		if( empty( $sortedSubpages ) ) {
			return '';
		}

		ksort( $sortedSubpages, SORT_NATURAL );

		$html = '<li><span class="nav-heading">' . wfMessage( 'rottweil-navigation-subpages' ) . '</span></li>';
		foreach( $sortedSubpages as $sortkey => $desc ) {
			$innerHtml = '<span class="rw-icon"></span><span class="rw-text">' . $desc['label'] . '</span>';
			$html .= '<li><a href="' . $desc['title']->getFullURL() . '" title="' . $desc['label'] . '">'. $innerHtml . '</a></li>';
		}

		return $html;
	}

	protected function makeSectionExternalLinks() {
		if( !$this->getSkin()->getTitle()->isMainPage() ) {
			return '';
		}

		$html = '<li><span class="nav-heading">' . wfMessage( 'rottweil-navigation-external' ) . '</span></li>';

		$content = wfMessage( "rottweil-navigation-external-links" )->plain();
		$externalLinks = explode( "\n", $content );
		$items = [];

		foreach( $externalLinks as $line ){
			$depth = 0;
			$isIndentCharacter = true;

			do {
				if ( isset( $line[$depth] ) && $line[$depth] == '*' ) $depth++;
				else $isIndentCharacter = false;
			}
			while ( $isIndentCharacter );

			$line = trim( substr( $line, $depth ) );

			if ( empty( $line ) ){ continue; }

			if ( $depth !== 1 ){
				continue;
			}

			$item = [];

			$external = false;
			if ( substr( $line , 0, 1 ) === '[' ) { $external = true; }
			if ( substr( $line , 0, 2 ) === '[[' ) { $external = false; }

			//external link
			if ( $external === true ) {
				$line = ltrim( $line, '[' );
				$line = rtrim( $line, ']' );

				$itemParts = explode( " ", $line );
				$item['href'] = $itemParts[0];

				array_shift( $itemParts );
				$itemText = implode( " ", $itemParts);
				$item['text'] = $itemText;
				$item['title'] = $itemText;

				$items[] = $item;
				continue;
			}

			//internal link
			if ( $external === false ) {
				$line = ltrim( $line, '[[' );
				$line = rtrim( $line, ']]' );
			}

			$elements = explode( '|', $line );

			$title = \Title::newFromText( $elements[0] );

			$item['href'] = $title->getFullURL();

			if ( isset( $elements[1] ) ){
				$item['text'] = $elements[1];
				$item['title'] = $elements[1];
			}
			else {
				$item['text'] = $title->getText();
				$item['title'] = $title->getText();
			}
			$items[] = $item;
		}

		foreach( $items as $item ){
			$html .= '<li><a href="' . $item['href'] . '" title="' . $item['title'] . '"><span class="rw-icon"></span><span class="rw-text">' . $item['text'] . '</span></a></li>';
		}

		return $html;
	}

	protected function makeSectionCurrentLinks() {
		if( !$this->getSkin()->getTitle()->isMainPage() ) {
			return '';
		}

		$html = '<li><span class="nav-heading">' . wfMessage( 'rottweil-navigation-current' ) . '</span></li>';

		$html .= '<li><a href="#news"><span class="rw-icon rw-icon-star"></span><span class="rw-text">' . wfMessage( 'rottweil-navigation-new-pages' ) . '</span></a></li>';
		$html .= '<li><a href="#newcomments"><span class="rw-icon rw-icon-star"></span><span class="rw-text">' . wfMessage( 'rottweil-navigation-new-comments' ) . '</span></a></li>';
		$html .= '<li><a href="http://www.guestbook-free.com/books3/nlh/"><span class="rw-icon rw-icon-star"></span><span class="rw-text">' . wfMessage( 'rottweil-navigation-guestbook' ) . '</span></a></li>';

		return $html;
	}

	protected function makeSectionToolbox() {
		$toobox = $this->getSkinTemplate()->get('nav_urls');
		$contentNavigation = $this->getSkinTemplate()->get( 'content_navigation' );

		$items = [];
		foreach( $toobox as $key => $value ){
			if( empty( $value ) ){
				continue;
			}
			if( !isset( $value['text'] ) ){
				$value['text'] = wfMessage( $key )->plain();
			}
			if( !isset( $value['title'] ) ){
				$value['title'] = $value['text'];
			}
			$items[$key] = $value;
		}

		/* delete */
		if( isset( $contentNavigation['actions']['delete'] ) ){
			$items['delete'] = $contentNavigation['actions']['delete'];
		
			if( !isset( $items['delete']['title'] ) ){
				$items['delete']['title'] = $items['delete']['text'];
			}
		}

		/* move */
		if( isset( $contentNavigation['actions']['move'] ) ){
			$items['move'] = $contentNavigation['actions']['move'];
		
			if( !isset( $items['move']['title'] ) ){
				$items['move']['title'] = $items['move']['text'];
			}
		}

		if( empty( $items ) ){
			return '';
		}

		$html = '<li><span class="nav-heading">' . wfMessage( 'rottweil-navigation-toolbox' ) . '</span></li>';

		foreach( $items as $item ){
			$id = ( isset( $item['id'] ) )? ' id="'. $item['id'] . '" ': '';
			$class = ( isset( $item['class'] ) )? ' class="'. $item['class'] . '" ': '';

			$html .= '<li><a ' . $id  . $class . ' href="' . $item['href'] . '" title="' . $item['title'] . '"><span class="rw-icon"></span><span class="rw-text">' . $item['text'] . '</span></a></li>';
		}

		return $html;
	}

	private function getRootPages() {
		$rootpages = [];
		$dbr = wfGetDB( DB_REPLICA );
		$pageTable =$dbr->tableName( 'page' );

		$res = $dbr->query( "SELECT * FROM $pageTable WHERE page_namespace = 0 AND page_title NOT LIKE '%/%'" );

		foreach( $res as $row ) {
			$rootpages[] = \Title::newFromRow( $row );
		}

		return $rootpages;
	}

	/**
	 * @param $defaultsort e.g ".220.Dez 2015 Laser-Show"
	 * @return string e.g. "Dez 2015 Laser-Show"
	 */
	private function makeLinkLabelFromDefaultSort( $defaultsort ) {
		$trimmedDefaultSort = trim( $defaultsort, '.' );
		$parts = explode( '.', $trimmedDefaultSort, 2 );
		$hasLeadingSort = ($parts[0]) === (((int)$parts[0]).'');

		if( count( $parts ) === 2 && $hasLeadingSort ) {
			return $parts[1];
		}

		return $defaultsort;
	}

}
