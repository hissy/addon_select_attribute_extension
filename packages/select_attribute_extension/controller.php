<?php 

defined('C5_EXECUTE') or die(_("Access Denied."));

class SelectAttributeExtensionPackage extends Package {

	protected $pkgHandle = 'select_attribute_extension';
	protected $appVersionRequired = '5.6.2';
	protected $pkgVersion = '0.1';

	public function getPackageDescription() {
		return t('Enables to set thumbnail, description, css-class to each select attribute options.');
	}

	public function getPackageName() {
		return t('Select Attribute Extension');
	}

	public function install() {
		$pkg = parent::install();
		$ci = new ContentImporter();
		$ci->importContentFile($pkg->getPackagePath() . '/install/content1.0.xml');
	}

}