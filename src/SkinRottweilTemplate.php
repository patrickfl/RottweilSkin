<?php
/**
 * BaseTemplate class for the Chameleon skin
 *
 * @author Stephan Gambke
 * @since 1.0
 * @ingroup Skins
 */
class SkinRottweilTemplate extends \Skins\Chameleon\ChameleonTemplate {
	public function __construct( \Config $config = null ) {
		parent::__construct( $config );
	}


	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		return parent::execute();
	}
}
