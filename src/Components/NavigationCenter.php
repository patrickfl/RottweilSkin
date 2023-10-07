<?php
namespace RottweilSkin\Components;

class NavigationCenter extends \Skins\Chameleon\Components\Structure {

	public function getHtml(){
		$class = $this->getDomElement()->getAttribute( 'class' );
		$class .= ' rw-navigation-center';

		$user = $this->getSkin()->getUser();
		$title = $this->getSkin()->getTitle();

		$html = \Html::openElement(
				'div',
				array(
					'class' => $class
				)
			);

		$content_nav = $this->getSkinTemplate()->get('content_navigation');

		$html .= \Html::openElement( 'ul', [ 'class' => 'rw-navigation-center-list' ] );

		if( true ){
			$html .= $this->addMainPageLink();
			$html .= $this->addClubLink();

			if ( \MediaWiki\MediaWikiServices::getInstance()->getPermissionManager()->userCan( 'edit', $user, $title ) ) {
				$html .= $this->addEditorLink();
			}

			$html .= $this->addSearchLink();
			$html .= $this->addServiceLink();
			$html .= $this->addImprintLink();
			$html .= $this->addPrivacyLink();

		}

		$html .= \Html::closeElement( 'ul' );

		$html .= \Html::closeElement( 'div' );

		//$html .= parent::getHtml();

		return $html;
	}

	protected function addMainPageLink() {
		$html .= \Html::openElement( 'li', [ 'class' => 'rw-navigation-center-item' ] );

		$title = \Title::newFromText( wfMessage( 'mainpage' )->plain() );

		$html .= \Html::element(
				'a',
				[
					'href' => $title->getFullURL(),
					'title' => $title->getFullText(),
					'class' => 'rw-navigation-center-link'
				],
				$title->getFullText()
			);

		$html .= \Html::closeElement( 'li' );
		return $html;
	}

	protected function addClubLink() {
		$html .= \Html::openElement( 'li', [ 'class' => 'rw-navigation-center-item' ] );

		$title = \Title::newFromText( wfMessage( 'rottweil-verein-page' )->plain() );

		$html .= \Html::element(
				'a',
				[
					'href' => $title->getFullURL(),
					'title' => wfMessage( 'rottweil-verein' )->plain(),
					'class' => 'rw-navigation-center-link'
				],
				wfMessage( 'rottweil-verein' )->plain()
			);

		$html .= \Html::closeElement( 'li' );
		return $html;
	}

	protected function addEditorLink() {
		$html .= \Html::openElement( 'li', [ 'class' => 'rw-navigation-center-item' ] );

		$title = $this->getSkin()->getTitle();

		$html .= \Html::element(
				'a',
				[
					'href' => $title->getFullURL ( 'action=edit' ),
					'title' => wfMessage( 'rottweil-navigation-center-editor-title' )->plain(),
					'class' => 'rw-navigation-center-link'
				],
				wfMessage( 'rottweil-navigation-center-editor-title' )->plain()
			);

		$html .= \Html::closeElement( 'li' );
		return $html;
	}

	protected function addSearchLink() {
		$html .= \Html::openElement( 'li', [ 'class' => 'rw-navigation-center-item' ] );

		$title = \Title::makeTitle( NS_SPECIAL, 'Search');

		$html .= \Html::element(
				'a',
				[
					'href' => $title->getFullURL(),
					'title' => wfMessage( 'search' ),
					'class' => 'rw-navigation-center-link'
				],
				wfMessage( 'search' )
			);

		$html .= \Html::closeElement( 'li' );
		return $html;
	}

	protected function addServiceLink() {
		$html .= \Html::openElement( 'li', [ 'class' => 'rw-navigation-center-item' ] );

		$html .= \Html::element(
				'a',
				[
					'href' => wfMessage( 'rottweil-navigation-center-service-page' )->plain(),
					'title' => wfMessage( 'rottweil-navigation-center-service-title' )->plain(),
					'class' => 'rw-navigation-center-link'
				],
				wfMessage( 'rottweil-navigation-center-service-title' )->plain()
			);

		$html .= \Html::closeElement( 'li' );
		return $html;
	}

	protected function addImprintLink() {
		$html .= \Html::openElement( 'li', [ 'class' => 'rw-navigation-center-item' ] );

		$title = \Title::newFromText( wfMessage( 'rottweil-navigation-main-impressum' )->plain() );
		$html .= \Html::element(
				'a',
				[
					'href' => $title->getFullURL(),
					'title' => wfMessage( 'rottweil-navigation-center-impressum-title' )->plain(),
					'class' => 'rw-navigation-center-link'
				],
				wfMessage( 'rottweil-navigation-center-impressum-title' )->plain()
			);

		$html .= \Html::closeElement( 'li' );
		return $html;
	}

	protected function addPrivacyLink() {
		$html .= \Html::openElement( 'li', [ 'class' => 'rw-navigation-center-item' ] );

		$title = \Title::newFromText( wfMessage( 'privacypage' )->plain() );
		$html .= \Html::element(
				'a',
				[
					'href' => $title->getFullURL(),
					'title' => wfMessage( 'privacy' )->plain(),
					'class' => 'rw-navigation-center-link'
				],
				wfMessage( 'privacy' )->plain()
			);

		$html .= \Html::closeElement( 'li' );
		return $html;
	}

}
