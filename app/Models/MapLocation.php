<?php

namespace App\Models;

use App\Traits\HasCreatedBy;
use App\Traits\HasImage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class MapLocation extends Model
{
    use SoftDeletes, HasCreatedBy, HasImage, LogsActivity;

    const IMAGE_DIRECTORY_PATH = '/uploads/locations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'zoom_from',
        'zoom_to',
        'title',
        'subtitle',
        'image',
        'description',
        'contact_name',
        'company',
        'address',
        'city',
        'postcode',
        'phone',
        'email',
        'search_activated',
        'search_text',
        'activated_at',
        'publish_at',
        'unpublish_at',
        'coordinates',
        'poi_id',
        'fixture_id',
        'beacon_id',
        'floor_id',
        'created_by'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'coordinates' => 'array',
        'search_activated' => 'boolean'
    ];

    /**.
     * @param  $value
     *
     * @return void
     */
    public function setCoordinatesAttribute($value)
    {
        $this->attributes['coordinates'] = json_encode($value);
    }

    /**
     * Set the date from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setPublishAtAttribute($value)
    {
        if ($value) {
            $this->attributes['publish_at'] = Carbon::parse($value)->format('Y-m-d');
        } else {
            $this->attributes['publish_at'] = null;
        }
    }

    /**
     * Set the date to
     *
     * @param  string $value
     *
     * @return void
     */
    public function setUnpublishAtAttribute($value)
    {
        if ($value) {
            $this->attributes['unpublish_at'] = Carbon::parse($value)->format('Y-m-d');
        } else {
            $this->attributes['unpublish_at'] = null;
        }
    }

    /**
     * Get the floor that owns the Location.
     */
    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    /**
     * Get the poi that owns the Location.
     */
    public function poi()
    {
        return $this->belongsTo(Poi::class);
    }

    /**
     * Get the fixture that owns the Location.
     */
    public function fixture()
    {
        return $this->belongsTo(Fixture::class);
    }

    /**
     * Get the beacon that owns the Location.
     */
    public function beacon()
    {
        return $this->belongsTo(Beacon::class);
    }

    /**
     * @return string|null
     */
    public function getType()
    {
        if ($this->poi_id) {
            return 'poi';
        } else if ($this->fixture_id) {
            return 'fixture';
        } else if ($this->beacon_id) {
            return 'beacon';
        }

        return null;
    }

}
