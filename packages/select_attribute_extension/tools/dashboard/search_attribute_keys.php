<?php	
defined('C5_EXECUTE') or die("Access Denied.");

// Check permission
$ch = Page::getByPath('/dashboard/pages/select_attribute_extension');
$cp = new Permissions($ch);
if (!$cp->canViewPage()) {
	die(t("Access Denied."));
}

// Validate request data
$akID = $_REQUEST['akID'];
if (!Loader::helper('validation/numbers')->integer($akID)) {
    die(t('Access Denied.'));
}

$ak = CollectionAttributeKey::getByID($akID);
$atc = $ak->getController();
if ($atc instanceOf SelectAttributeTypeController) {
	$optionList = $atc->getOptions();
	if ($optionList->count() > 0) {
		$options = $optionList->getOptions();
		$selectOptions = array();
		foreach ($options as $opt) {
			$selectOptions[$opt->getSelectAttributeOptionID()] = $opt->getSelectAttributeOptionValue();
		}
		echo Loader::helper('form')->select('ID',$selectOptions);
	}
} else {
	echo t('Please select select type attribute.'); 
}
