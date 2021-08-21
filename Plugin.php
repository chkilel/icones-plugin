<?php namespace Chkilel\Icones;

use ApplicationException;
use Backend;
use System\Classes\PluginBase;
use Chkilel\Icones\Classes\JsonIcon;
use Chkilel\Icones\FormWidgets\IconesFinder;
use Chkilel\Icones\Models\Settings;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label' => 'chkilel.icones::lang.settings.label',
                'description' => 'chkilel.icones::lang.settings.description',
                'icon' => 'icon-bomb',
                'url' => Backend::url('chkilel/icones/settings'),
                'category' => 'system::lang.system.categories.cms',
                'order' => 500,
                'permissions' => ['chkilel.icones.access_settings'],
                'keywords' => 'svg icones icon iconify'
            ],
        ];
    }


    public function registerFormWidgets()
    {
        return [
            IconesFinder::class => 'iconesfinder'
        ];
    }


    public function registerMarkupTags()
    {
        return [
            'filters' => [
                'iconify' => [$this, 'iconify']
            ],
        ];
    }


    public function registerListColumnTypes()
    {
        return [
            'iconesthumb' => [$this, 'iconThumbListColumn'],
        ];
    }


    /**
     * @param $value the JSON value on which the filter is applied
     * @param $props associative array with the folowing possible keys (see REEDME.md):
     * 'class','width', 'height', 'inline', 'hFlip', 'vFlip', 'flip', 'rotate', 'align', 'color', 'box'
     * @return string SVG icon
     * @throws ApplicationException
     */
    public function iconify($jsonIcon, $props = [])
    {
        $icon = new JsonIcon($jsonIcon);
        return $icon->iconify($props);
    }


    /**
     * @param $value the JSON representation of the icon
     * @param $column column definition object
     * @param $record  model record object.
     * @return string SVG icon
     * @throws ApplicationException
     */
    public function iconThumbListColumn($value, $column, $record)
    {
        $props = ['inline' => true];
        $props['height'] = $column->config['height'] ?? 24;

        $icon = new JsonIcon($value);

        return $icon->iconify($props);
    }
}
