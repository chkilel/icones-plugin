<?php namespace Chkilel\Icones\Classes;

use ApplicationException;
use Chkilel\Icones\Models\Icon;

class JsonIcon
{


    // Serialized icon from DB
    protected $jsonIcon;

    // Icon model
    protected $icon;

    public function __construct($jsonIcon)
    {

        if ($jsonIcon != null) {
            $this->jsonIcon = $jsonIcon;

            $keys = [
                "id", "icon_set_id", "name", "parent", "icon_set_name", "body", "hidden",
                "left", "top", "width", "height", "rotate", "hFlip", "vFlip",
                "inlineTop", "inlineHeight", "verticalAlign"
            ];

            // We check if the given value is a Json representation of an icon.
            $iconArray = json_decode($jsonIcon, true) ?? [];
            $iconArrayKeys = array_keys($iconArray);
            $isIcon = count(array_diff($keys, $iconArrayKeys)) == 0;

            if ($isIcon) {
                //Although we could grab the model by its Id,  We constructed the object from the Json,
                // I'm doing this sort of double-checking
                $icon = Helpers::mapIcon($iconArray);
                $this->icon = $icon;
            } else {
                throw new ApplicationException(trans("chkilel.icones::lang.formwidgets.error_wrong_variable_type"));
            }
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
