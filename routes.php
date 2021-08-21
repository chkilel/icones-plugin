<?php namespace Chkilel\Icones;

use Chkilel\Icones\Classes\Helpers;

use Route;

Route::get('icons', function (){
    return Helpers::searcheIcons(20);
});
