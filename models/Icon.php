<?php

namespace Chkilel\Icones\Models;

use Iconify\JSONTools\SVG;
use Model;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Validation;

class Icon extends Model
{
    use SoftDelete;
    use Validation;

    public $table = 'chkilel_icones_icons';

    protected $guarded = ['*'];

    public $rules = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'left' => 'integer',
        'top' => 'integer',
        'width' => 'integer',
        'height' => 'integer',
        'rotate' => 'integer',
        'inlineTop' => 'integer',
        'inlineHeight' => 'integer',
        'verticalAlign' => 'float',
        'hidden' => 'boolean',
        'hFlip' => 'boolean',
        'vFlip' => 'boolean',
    ];

    public $belongsTo = [
        'iconSet' => IconSet::class,
    ];

    public function scopeWithTrashedIcons($query)
    {
        return $query->withTrashed();
    }

    public function toSVG($props = [])
    {
        $svg = new SVG($this->getArrayableAttributes());

        return $svg->getSVG($props, true);
    }
}
