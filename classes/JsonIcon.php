<?php namespace Chkilel\Icones\Classes;

use Chkilel\Icones\Models\Icon;

class JsonIcon
{
    // Icon model
    protected $icon;

    public function __construct($jsonIcon)
    {
        // $jsonIcon is the Serialized icon from DB
        if ($jsonIcon != null) {
            $this->icon = Helpers::mapIcon($jsonIcon);
        }
    }


    /**
     * Get SVG from Icon model
     * @param array $props Options for generating SVG
     * @return string
     * @throws ApplicationException
     */
    public function iconify($props = [])
    {
        if ($this->icon) {
            // Merge the provided classes with icon classes
            $iconClass = "icones " . $this->icon->icon_set_id . " " . $this->icon->name;
            $iconClass .= (isset($props['class']) ? " " . $props['class'] : '');

            $props = array_merge($props, ['class' => $iconClass]);

            return $this->icon->toSVG($props);
        }
    }
}
