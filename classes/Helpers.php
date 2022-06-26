<?php namespace Chkilel\Icones\Classes;

use Chkilel\Icones\Models\Icon;
use Chkilel\Icones\Models\IconSet;
use ApplicationException;
use Iconify\JSONTools\Collection as IconifyCollection;

class Helpers
{

    /**
     * Results returned for the searched term,
     * @param $perPage
     * @return array
     */
    public static function searcheIcons($perPage = 20)
    {
        // Searched term
        $searchTerm = get('search');

        // Icon sets provided in the field options
        $iconSets = get('icon_sets');

        // ShowName option for the field
        $showName = get('show_icon_name');

        // ShowIconSetName option for the field
        $showIconSetName = get('show_icon_set_name');

        // Size option for the field
        $fieldSize = get('size');

        // All enabled icon sets in the backend settings page
        $enabledIconSets = IconSet::where('is_enabled', true)->pluck('id')->toArray();

        if ($iconSets != null) {
            // If the field's option `iconSet` is provided,
            // it's an array of icon sets sent in the query parameter to search within.
            $searchableIconSets = array_intersect($iconSets, $enabledIconSets);
        } else {
            // If the field's option `iconSet` is not set, Search all enabled icon sets
            $searchableIconSets = $enabledIconSets;
        }

        // Paginate results to send to Select2
        $paginator = Icon::whereIn('icon_set_id', $searchableIconSets)
            ->where('readable_name', 'LIKE', "%{$searchTerm}%")
            ->with('iconSet')
            ->simplePaginate($perPage);


        // Select2 pagination ("infinite scrolling") for remote data sources
        // needs an object with 'results' and  'pagination'
        // Here we construct the results, and we return it beside the pagination parameter
        $results = [];

        foreach ($paginator->Items() as $index => $icon) {
            // If icon is hidden. That means icon was removed from collection for some reason,
            // but it is kept in JSON file to prevent applications that rely on old icon from breaking
            if (!$icon->hidden) {
                $icon['svg'] = $icon->toSVG([
                    'height' => Helpers::setSvgHeight($fieldSize),
                    'inline' => true]);
                $icon['readable_name'] = $showName ?  $icon['name']: '' ;
                $icon['icon_set_name'] = $showIconSetName ?  $icon['icon_set_name']: '' ;
                $results[$index] = $icon;
            }
        }

        return [
            'results' => $results,
            'pagination' => ['more' => $paginator->hasMorePages()]
        ];
    }


    /**
     * Seed Icons for a specific Icon Set, used in the backend settings.
     *
     * @param $prefix String icon set name abbreviation
     * @return bool to confirm seeding ok
     */
    public static function installIconSet($prefix)
    {
        $iconsToSave = [];

        $iconSet = new IconifyCollection();
        $iconSet->loadIconifyCollection($prefix);

        // List of Icons' names including icons' Aliases
        $iconList = $iconSet->listIcons(true);

        foreach ($iconList as $iconName) {
            $iconData = $iconSet->getIconData($iconName);

            // We add other attributes that we need
            // Icon set prefix (=id in db), can be like "mdi" for "Material Design Icons"
            $iconData['icon_set_id'] = $prefix;
            $iconData['name'] = $iconName;
            $iconData['readable_name'] = ucwords(str_replace('-', ' ', $iconName));

            // Must be set to null for parent icons because `parent` attribute is set only for aliases
            $iconData['parent'] = $iconData['parent'] ?? null;

            // The readable Icon set name, like "Material Design Icons"
            $iconData['icon_set_name'] = $iconSet->items['info']['name'];

            /**   Hidden icons:
             *      If hidden  set to true, icon is hidden. That means icon was removed from iconSet for some reason,
             *      but it is kept in JSON file to prevent applications that rely on old icon from breaking.
             *      Set only for hidden icons in JSON, must be set to false (default)
             *      to seed data (all columns are needed)
             **/
            $iconData['hidden'] = $iconData['hidden'] ?? false;

            // I'm using "Icon::insert" to seed data, so I need to set timestamps manualy
            $iconData['created_at'] = now()->toDateTimeString();
            $iconData['updated_at'] = now()->toDateTimeString();

            $iconsToSave[] = $iconData;
        }


        // For optimal seeding, because number of icons can be huge
        $chunks = array_chunk($iconsToSave, 200);

        foreach ($chunks as $chunk) {
            Icon::insert($chunk);
        }
        return true;
    }

    /**
     * Mape the arry representation of icon's attributes to an Icon model
     * @param $iconArray
     * @return Icon
     */
    public static function mapIcon($iconArray)
    {
        $keys = [
            "id", "icon_set_id", "name", "parent", "icon_set_name", "readable_name", "body", "hidden",
            "left", "top", "width", "height", "rotate", "hFlip", "vFlip",
            "inlineTop", "inlineHeight", "verticalAlign"
        ];

        // We check if the given value is an Array  representation of an icon.
        $iconArrayKeys = array_keys($iconArray);
        $isIcon = count(array_diff($keys, $iconArrayKeys)) == 0;

        if ($isIcon) {
            //Although we could grab the model by its Id,  We construct the object from the array,
            // in case the icon is no more in DB if the icon set is deleted for example
            $icon = new Icon();
            foreach ($iconArray as $key => $attribute) {
                $icon->{$key} = $attribute;
            }
        } else {
            throw new ApplicationException(trans("chkilel.icones::lang.formwidgets.error_wrong_variable_type", [
                'variable' => $iconArray,
                'type' =>gettype($iconArray),
            ]));
        }

        return $icon;
    }

    /**
     * Set the size of the svg depending on the field size option
     * @param $size small|large
     * @return int
     */
    public static function setSvgHeight($fieldSize)
    {
        if ($fieldSize == 'large') {
            return 24;
        }
        return 16;
    }
}
