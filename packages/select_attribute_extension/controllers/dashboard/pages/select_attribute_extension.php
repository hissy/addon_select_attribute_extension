<?php
defined('C5_EXECUTE') or die("Access Denied.");

class DashboardPagesSelectAttributeExtensionController extends DashboardBaseController {
	
	public function view() {
		Loader::model('select_option_extension_list','select_attribute_extension');
		$soeList = new SelectOptionExtentionList();
		$dataArray = $soeList->get();
		$this->set('dataArray',$dataArray);
	}
	
	public function select() {
		$attribs = CollectionAttributeKey::getList();
		$akOptions = array();
		foreach ($attribs as $ak) {
			$akOptions[$ak->getAttributeKeyID()] = tc('AttributeKeyName', $ak->getAttributeKeyName());
		}
		
		$this->set('akOptions',$akOptions);
	}
	
	public function add($akID = 0, $ID = 0) {
		$akID = ($this->post('akID')) ? $this->post('akID') : $akID;
		$ID = ($this->request('ID')) ? $this->request('ID') : $ID;
		
		$ak = CollectionAttributeKey::getByID($akID);
		$atSelectOption = SelectAttributeTypeOption::getByID($ID);
		if (is_object($atSelectOption)) {
			$this->set('ak',$ak);
			$this->set('atSelectOption',$atSelectOption);
			
			Loader::model('select_option_extension','select_attribute_extension');
			$soe = SelectOptionExtention::getByID($ID);
			$thumbnail = File::getByID($soe->getThumbnailID());
			$this->set('thumbnail',$thumbnail);
			$this->set('description',$soe->getDescription());
			$this->set('class',$soe->getCssClass());
		} else {
			$this->redirect('/dashboard/pages/select_attribute_extension');
		}
	}
	
	public function saved() {
		$this->set("message", t('Option saved successfully.'));
		$this->view();
	}
	
	public function add_select_extension() {
		if ($this->token->validate("add_select_extension")) {	
			$valn = Loader::helper('validation/numbers');
			$vals = Loader::helper('validation/strings');
			
			$akID = $this->post('akID');
			$data = array(
				'ID' => $this->post('ID'),
				'thumbnail' => $this->post('thumbnail'),
				'description' => $this->post('description'),
				'class' => $this->post('class')
			);
			
			if (!$vals->notempty($data['thumbnail']) && !$vals->notempty($data['description']) && !$vals->notempty($data['class'])) {
				$this->error->add(t('You must specify at least one data for selected attribute option.'));
			} elseif (!$valn->integer($data['thumbnail'])) {
				$this->error->add(t('Invalid file.'));
			} elseif (!$vals->alphanum($data['class'],true)) {
				$this->error->add(t('Invalid css class.'));
			}
			
			if ($this->error->has()) {
				$this->set('data',$data);
				$this->add($akID,$data['ID']);
			} else {
				Loader::model('select_option_extension','select_attribute_extension');
				SelectOptionExtention::save($data);
				
				$this->redirect('/dashboard/pages/select_attribute_extension','saved');
			}
		} else {
			$this->set('error', array($this->token->getErrorMessage()));
		}
		
	}
	
}