# Select Attribute Extension

A package for concrete5. Enables to set thumbnail, description, css-class to each select attribute options.

## Usage

```
<?php
// Load Model
Loader::model('select_option_extension','select_attribute_extension');

// Get current page
$c = Page::getCurrentPage();

// Get tags attribute of current page
$tags = $c->getAttribute('tags');

// Get option list
$options = $tags->getOptions();

foreach ($options as $opt) {

	// Get option value
	$optValue = $opt->getSelectAttributeOptionValue();
	
	// Get option ID
	$optID = $opt->getSelectAttributeOptionID();
	
	// Get extension data
	$ext = SelectOptionExtention::getByID($optID);
	
	// Get option thumbnail file ID
	$fID = $ext->getThumbnailID();
	
	// Get option description
	$description = $ext->getDescription();
	
	// Get option CSS class
	$class = $ext->getCssClass();
	
}
```
