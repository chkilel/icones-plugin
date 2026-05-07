<?php

use Chkilel\Icones\Classes\Helpers;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->get('icons', Helpers::class.'@searcheIcons');
