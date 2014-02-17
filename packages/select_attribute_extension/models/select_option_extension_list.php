<?php
defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package select_attribute_extension
 *
 */
class SelectOptionExtentionList extends DatabaseItemList {
	
	private $queryCreated;
	protected $itemsPerPage = 10;
	
	protected function setBaseQuery() {
		$this->setQuery('select ID from atSelectOptionExtentions');
	}
	
	public function createQuery() {
		if (!$this->queryCreated) {
			$this->setBaseQuery();
			$this->queryCreated = 1;
		}
	}
	
	public function get($itemsToGet = 0, $offset = 0) {
		Loader::model('select_option_extension','select_attribute_extension');
		$selectOptionExtentionList = array();
		$this->createQuery();
		$r = parent::get($itemsToGet, $offset);
		foreach ($r as $row) {
			$selectOptionExtention = SelectOptionExtention::getByID($row['ID']);
			$selectOptionExtentionList[] = $selectOptionExtention;
		}
		return $selectOptionExtentionList;
	}
	
	public function getTotal() {
		$this->createQuery();
		return parent::getTotal();
	}
	
}