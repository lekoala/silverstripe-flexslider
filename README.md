SilverStripe FlexSlider module
==================

This module provide all the requirements to use FlexSlider 2.6 in your website.

Use the following code in your page:

    private static $has_many = array(
        'Slides' => 'FlexSliderSlide'
    );

    function getCMSFields() {
        $fields = parent::getCMSFields();

        FlexSliderSlide::attach($fields,$this);

        return $fields;
    }

And simply require the slider in your template:

    <% include FlexSlider %>

Full screen slider
----------------------------------

For a nice full screen slider, images must be set as background. You can use
this in your template instead:

    <% include FlexSliderBackground %>

Make sure to have the following css:

    html, 
    body {
      height: 100%;
      min-height: 100%;
    }

The default css has been updated to support fullscreen with the flexslider-fullscreen
class.

Manually trigger requirements
----------------------------------

    function init() {
        parent::init();

        FlexSliderSlide::requirements();
    }

Configuration
----------------------------------

- custom_styles: Allows you to specify a custom stylesheet instead of the default one.
A sample custom stylesheet using elegant icons is provided.

- custom_init: Don't use auto init and use your own code to specify your options

- animation: Default animation to be used.

- image_width: Automatically resize image

Compatibility
==================
Tested with 3.1, 3.2

Maintainer
==================
LeKoala - thomas@lekoala.be