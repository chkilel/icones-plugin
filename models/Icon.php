<?php namespace Chkilel\Icones\Models;

use Iconify\JSONTools\SVG;
use Model;

/**
 * Icon Model
 */
class Icon extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'chkilel_icones_icons';

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
    protected $casts = [];

    /**
     * @var array Attributes to be cast to JSON
     */
    protected $jsonable = [];

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
    public $hasMany = [];
    public $hasOneThrough = [];
    public $hasManyThrough = [];
    public $belongsTo = [
        'iconSet' => \Chkilel\Icones\Models\IconSet::class,
    ];
    public $belongsToMany = [];
    public $morphTo = [];
    public $morphOne = [];
    public $morphMany = [];
    public $attachOne = [];
    public $attachMany = [];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeWithTrashedIcons($query)
    {
        return $query->withTrashed();
    }


    /**
     * Get the svg from an Icon model
     *
     * @param $props associative array with the folowing possible keys (see REEDME.md):
     * 'class','width', 'height', 'inline', 'hFlip', 'vFlip', 'flip', 'rotate', 'align', 'color', 'box'
     * @return string
     */
    public function toSVG($props = [])
    {
        $svg = new SVG($this->getArrayableAttributes());

        return $svg->getSVG($props, true);
    }
}
