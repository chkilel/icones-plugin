<?php namespace Chkilel\Icones\Models;

use Model;

/**
 * IconSet Model
 */
class IconSet extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'chkilel_icones_icon_sets';


    /**
     * Indicates if the IDs are auto-incrementing.
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the ID.
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var array Guarded fields
     */
    protected $guarded = ['*'];

    /**
     * @var array Fillable fields
     */
    protected $fillable = [];

    /**
     * @var array Validation rules for attributes
     */
    public $rules = [];

    /**
     * @var array Attributes to be cast to native types
     */
    protected $casts = [
        'is_enabled' => 'boolean',
        'is_installed' => 'boolean',
    ];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [
        'height',
        'samples'
    ];

    /**
     * @var array Attributes to be appended to the API representation of the model (ex. toArray())
     */
    protected $appends = [];

    /**
     * @var array Attributes to be removed from the API representation of the model (ex. toArray())
     */
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @var array Attributes to be cast to Argon (Carbon) instances
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * @var array Relations
     */
    public $hasOne = [];
    public $hasMany = [
        //'icons' => \Chkilel\Icones\Models\Icon::class,
        'withTrashedIcons' => [
            \Chkilel\Icones\Models\Icon::class,
            'scope' => 'withTrashedIcons',
        ]
    ];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];


    /**
     * @return boolean
     * True if Icon Set is enabled
     */
    public function isEnabled()
    {
        return $this->is_enabled;
    }

    /**
     * @return boolean
     * True if the Icon Set is installed
     */
    public function isInstalled()
    {
        return $this->is_installed;
    }

    /**
     * Number of icon to showcase on the setting page
     * @return Icon collection of icons
     */
    public function iconsToShowcase()
    {
        return $this->withTrashedIcons()->inRandomOrder()->take(9);
//        return $this->icons()->take(9);
    }
}
