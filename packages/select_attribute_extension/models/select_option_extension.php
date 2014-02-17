<?php
defined('C5_EXECUTE') or die("Access Denied.");
/**
 * @package select_attribute_extension
 *
 */
class SelectOptionExtention extends Object {
	
	public function delete() {
		$db = Loader::db();
		$db->Execute('delete from atSelectOptionExtentions where ID = ?', array($this->ID));
	}
	
	public function save($data) {
		$db = Loader::db();
		$db->Replace('atSelectOptionExtentions', array('ID' => $data['ID'],
			'thumbnail' => $data['thumbnail'],
			'description' => $data['description'],
			'class' => $data['class']
			), 'ID', true
		);
	}
	
	/**
	 * returns the SelectOptionExtention object by ID
	 * @param int $ID
	 * @return SelectOptionExtention
	 */
	public static function getByID($ID) {
		$db = Loader::db();
		$r = $db->GetRow('select * from atSelectOptionExtentions where ID = ?', array($ID));
		$soe = new SelectOptionExtention();
		$soe->setPropertiesFromArray($r);
		if (is_a($soe, "SelectOptionExtention")) {
			return $soe;
		}
	}
	
	public function getID() {
		return $this->ID;
	}
	
	public function getThumbnailID() {
		return $this->thumbnail;
	}
	
	public function getDescription($sanitize = true) {
		if (!$sanitize) {
			return $this->description;
		} else {
			return h($this->description);
		}
	}
	
	public function getCssClass($sanitize = true) {
		if (!$sanitize) {
			return $this->class;
		} else {
			return h($this->class);
		}
	}
	
}