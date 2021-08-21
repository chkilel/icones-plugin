<?php namespace Chkilel\Icones\FormWidgets;

use Backend\Classes\FormWidgetBase;
use Chkilel\Icones\Classes\Helpers;
use Chkilel\Icones\Models\Icon;

/**
 * IconesFinder Form Widget
 */
class IconesFinder extends FormWidgetBase
{
    //
    // Configurable properties
    //

    /**
     * @var bool Display icon's name in the field beside the icon.
     */
    public $showName = true;

    /**
     * @var bool Display icon set's name in the field.
     */
    public $showIconSetName = true;

    /**
     * @var string specifies a field size. Options: small, large.
     */
    public $size = '';

    /**
     * @var String Placeholder to display.
     */
    public $placeholder = '';

    /**
     * @var array  Set the icon sets to choose from.
     */
    public $iconSets = [];

    /**
     * @inheritDoc
     */
    protected $defaultAlias = 'iconesfinder';

    /**
     * @inheritDoc
     */
    public function init()
    {
        $this->fillFromConfig([
            'showName',
            'showIconSetName',
            'size',
            'iconSets',
            'placeholder',
        ]);
    }

    /**
     * @inheritDoc
     */
    public function render()
    {
        $this->prepareVars();
        return $this->makePartial('iconesfinder');
    }

    /**
     * Prepares the form widget view data
     */
    public function prepareVars()
    {
        $this->vars['id'] = $this->formField->getId();
        $this->vars['name'] = $this->formField->getName();
        $this->vars['value'] = $this->getLoadValue();
        $this->vars['model'] = $this->model;

        $this->vars['showName'] = $this->showName;
        $this->vars['showIconSetName'] = $this->showIconSetName;
        $this->vars['size'] = $this->size;

        if (!is_array($this->iconSets)) {
            $this->iconSets = explode('|', $this->iconSets);
        }
        $this->vars['iconSets'] = $this->iconSets;
        $this->vars['placeholder'] = $this->placeholder;

        $this->vars['svgProps'] = [
            'inline' => true,
            'height' => Helpers::setSvgHeight($this->size)
        ];
        $this->vars['sizeClass'] = $this->setSizeClass($this->size);
    }

    /**
     * @inheritDoc
     */
    public function loadAssets()
    {
        $this->addCss('css/iconesfinder.css', 'Chkilel.Icones');
    }

    /**
     * Store value as a Json string or null
     *
     * @inheritDoc
     */
    public function getSaveValue($value)
    {

        // Case when the field is empty
        if ($value == null) {
            return null;
        }

        // To manage the case where the form is saved but the icon is no more in the DB;
        // for example the icon set is deleted.
        // We reuse the existing value stored as JSON, otherwise we will be calling toJSON on null
        $serialized = $this->formField->value;

        $icon = Icon::find($value);
        if ($icon != null) {
            $serialized = $icon->toJSON();
        }

        return $serialized;
    }


    /**
     * @inheritDoc
     */
    public function getLoadValue()
    {
        if ($this->formField->value != null) {
            $iconArray = json_decode($this->formField->value);

            $icon = Helpers::mapIcon($iconArray);

            $icon->svg = $icon->toSVG([
                'inline' => true,
                'height' => Helpers::setSvgHeight($this->size),
            ]);

            return $icon;
        }
    }

    /**
     * Return the class to adjust the size of th fied
     *
     * @param $size small|large
     * @return string
     */
    public function setSizeClass($size)
    {
        switch ($size) {
            case 'small':
                return 'form-group-sm';
                break;
            case 'large':
                return 'form-group-lg';
                break;
            default:
                return '';
        }
    }
}
