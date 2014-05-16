<?php

/**
 * FlexsliderItem
 *
 * @author Koala
 */
class FlexsliderSlide extends DataObject {
	
	private static $db = array(
		'Title' => 'Varchar(255)',
		'Description' => 'HTMLText',
		'SortOrder' => 'Int'
	);
	private static $has_one = array(
		'Image' => 'Image',
		'SiteTree' => 'SiteTree'
	);
	private static $summary_fields = array(
		'SortOrder', 'Title', 'Image.CMSThumbnail'
	);
	private static $default_sort = 'SortOrder ASC';
	
	/**
	 * Attach the slides to a dataobject
	 * 
	 * @param FiedList $fields
	 * @param DataObject $obj
	 * @param string $relation
	 */
	static function attach(FiedList &$fields, $obj,$relation = 'Slides') {
		$config = new GridFieldConfig_RelationEditor;
		if(class_exists('GridFieldSortableRows')) {
			$config->addComponent($sortable=new GridFieldSortableRows('SortOrder'));
			$sortable->setAppendToTop(true);
		}
		$gridfield = new GridField($relation,$relation,$obj->$relation(),$config);
		$fields->addFieldToTab('Root.' . $relation,$gridfield);
	}
	
	/**
	 * Require files
	 */
	static function requirements() {
		$animation = Config::inst()->get(__CLASS__,'animation');
		if(!$animation) {
			$animation = 'slide';
		}
		
		Requirements::css('flexslider/css/flexslider.css');
		Requirements::javascript('flexslider/javascript/jquery.flexslider-min.js');
		Requirements::customScript(<<<JS
$(window).load(function() {
	$('.flexslider').flexslider({
	  animation: "$animation",
	});
});
JS
		  );
	}
	
	function forTemplate() {
		return $this->renderWith(__CLASS__);
	}
	
	function SlideClass() {
		if($this->ImageID) {
			return 'flexslider-slide-image';
		}
		return 'flexslider-slide-simple';
	}
	
	function HasContent() {
		return $this->Title || $this->Description;
	}
	
	function ResizedImage() {
		if(!$this->ImageID) {
			return false;
		}
		$width = Config::inst()->get(__CLASS__,'image_width');
		if(!$width) {
			$width = 1200;
		}
		return $this->Image()->SetWidth($width); 
	}
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		$fields->dataFieldByName('Description')->setRows(5);
		
		/* @var $uploadField UploadField */
		$uploadField = $fields->dataFieldByName('Image');
		$uploadField->setFolderName(__CLASS__);
		
		return $fields;
	}
}
