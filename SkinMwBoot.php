<?php

class SkinMwBoot extends SkinTemplate {

	public $skinname = 'mwboot';
	public $stylename = 'MwBoot';
	public $template = 'MwBootTemplate';
	public $useHeadElement = true;

	public function initPage( OutputPage $out ) {
		parent::initPage( $out );
		$out->addModules( 'skins.mwboot.js' );
	}

	public function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
		$out->addModuleStyles( 'skins.mwboot');
	}

}
