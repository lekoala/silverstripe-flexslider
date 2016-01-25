<?php

/**
 * A slide item
 *
 * @property string $Title
 * @property string $Content
 * @property int $SortOrder
 * @property int $ImageID
 * @property int $PageID
 * @method Image Image()
 * @method Page Page()
 * 
 * @author Koala
 */
class FlexSliderSlide extends DataObject
{
    private static $db             = array(
        'Title' => 'Varchar(255)',
        'Content' => 'HTMLText',
        'SortOrder' => 'Int'
    );
    private static $has_one        = array(
        'Image' => 'Image',
        'Page' => 'Page'
    );
    private static $summary_fields = array(
        'Title', 'Image.CMSThumbnail'
    );
    private static $default_sort   = 'SortOrder ASC';

    /**
     * Attach the slides to a dataobject
     *
     * @param FieldList $fields
     * @param DataObject $obj
     * @param string $relation
     */
    static function attach(FieldList $fields, $obj, $relation = 'Slides')
    {
        $config = new GridFieldConfig_RecordEditor;
        if (class_exists('GridFieldSortableRows')) {
            $config->addComponent($sortable = new GridFieldSortableRows('SortOrder'));
            $sortable->setAppendToTop(true);
        } else if (class_exists('GridFieldOrderableRows')) {
            $config->addComponent($sortable = new GridFieldOrderableRows('SortOrder'));
        }
        $gridfield = new GridField($relation, $relation, $obj->$relation(),
            $config);
        $fields->addFieldToTab('Root.'.$relation, $gridfield);
    }

    /**
     * Require files
     */
    static function requirements($customOpts = array())
    {
        $config    = self::config();
        $animation = $config->animation;
        if (!$animation) {
            $animation = 'slide';
        }

        if (!$config->custom_styles) {
            Requirements::css('flexslider/css/flexslider.min.css');
        }
        Requirements::javascript('flexslider/javascript/jquery.flexslider-min.js');

        $opts = $config->default_opts ? $config->default_opts : [];

        $opts = array_merge($opts,$customOpts);

        if (!$config->custom_init) {
            Requirements::customScript('$(window).load(function() {$(\'.flexslider\').flexslider('.json_encode($opts).');});');
        }
    }

    function forTemplate()
    {
        self::requirements();
        return $this->renderWith(__CLASS__);
    }

    function MeBackground()
    {
        self::requirements(array(
            'smoothHeight' => false
        ));
        return $this->renderWith(__CLASS__.'Background');
    }

    function SlideClass()
    {
        if ($this->ImageID) {
            return 'flexslider-slide-image';
        }
        return 'flexslider-slide-simple';
    }

    function HasContent()
    {
        return $this->Title || $this->Content;
    }

    function ResizedImage()
    {
        if (!$this->ImageID) {
            return false;
        }
        $width = self::config()->image_width;
        if (!$width) {
            return $this->Image();
        }
        return $this->Image()->SetWidth($width);
    }

    function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->dataFieldByName('Content')->setRows(5);

        if (class_exists('GridFieldSortableRows') || class_exists('GridFieldOrderableRows')) {
            $fields->removeByName('SortOrder');
        }

        $page = $this->PageID ? $this->Page() : Controller::curr()->currentPage();

        /* @var $uploadField UploadField */
        $uploadField = $fields->dataFieldByName('Image');
        $uploadField->setFolderName($page->URLSegment);

        return $fields;
    }

    protected function onBeforeWrite()
    {
        if (!$this->SortOrder) {
            $this->SortOrder = self::get()->max('SortOrder') + 1;
        }

        parent::onBeforeWrite();
    }
}