Silverstripe Flexslider module
==================
Use Flexslider in Silverstripe

Use the following code in your page

	private static $has_many = array(
		'Slides' => 'FlexsliderSlide'
	);
		
	function getCMSFields() {
		$fields = parent::getCMSFields();
		
		FlexsliderSlide::attach($fields,$this);
		
		return $fields;
	}

And the following code in your controller

	function init() {
		parent::init();
		
		FlexsliderSlide::requirements();
	}

Default templates are available as include but can be customized to your needs

Compatibility
==================
Tested with 3.1

Maintainer
==================
LeKoala - thomas@lekoala.be