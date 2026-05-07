<?php

namespace Chkilel\Icones\Models;

use Model;
use October\Rain\Database\Traits\SoftDelete;
use October\Rain\Database\Traits\Validation;

class IconSet extends Model
{
    use SoftDelete;
    use Validation;

    public $table = 'chkilel_icones_icon_sets';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = ['*'];

    public $rules = [];

    protected $casts = [
        'is_enabled' => 'boolean',
        'is_installed' => 'boolean',
        'palette' => 'boolean',
        'height' => 'array',
        'samples' => 'array',
        'display_height' => 'integer',
        'total' => 'integer',
    ];

    protected $jsonable = [
        'height',
        'samples',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public $hasMany = [
        'withTrashedIcons' => [
            Icon::class,
            'scope' => 'withTrashedIcons',
        ],
    ];

    public function isEnabled(): bool
    {
        return $this->is_enabled;
    }

    public function isInstalled(): bool
    {
        return $this->is_installed;
    }

    public function iconsToShowcase()
    {
        return $this->withTrashedIcons()->inRandomOrder()->take(9);
    }
}
