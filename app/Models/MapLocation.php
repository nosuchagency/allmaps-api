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
        'monday_from',
        'monday_to',
        'tuesday_from',
        'tuesday_to',
        'wednesday_from',
        'wednesday_to',
        'thursday_from',
        'thursday_to',
        'friday_from',
        'friday_to',
        'saturday_from',
        'saturday_to',
        'sunday_from',
        'sunday_to',
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
     * Get monday from
     *
     * @param  string $value
     *
     * @return string
     */
    public function getMondayFromAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set monday from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setMondayFromAttribute($value)
    {
        if ($value) {
            $this->attributes['monday_from'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['monday_from'] = null;
        }
    }

    /**
     * Get monday to
     *
     * @param  string $value
     *
     * @return string
     */
    public function getMondayToAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set monday to
     *
     * @param  string $value
     *
     * @return void
     */
    public function setMondayToAttribute($value)
    {
        if ($value) {
            $this->attributes['monday_to'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['monday_to'] = null;
        }
    }

    /**
     * Get tuesday from
     *
     * @param  string $value
     *
     * @return string
     */
    public function getTuesdayFromAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set tuesday from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setTuesdayFromAttribute($value)
    {
        if ($value) {
            $this->attributes['tuesday_from'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['tuesday_from'] = null;
        }
    }

    /**
     * Get tuesday to
     *
     * @param  string $value
     *
     * @return string
     */
    public function getTuesdayToAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set tuesday from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setTuesdayToAttribute($value)
    {
        if ($value) {
            $this->attributes['tuesday_to'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['tuesday_to'] = null;
        }
    }

    /**
     * Get wednesday from
     *
     * @param  string $value
     *
     * @return string
     */
    public function getWednesdayFromAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set wednesday from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setWednesdayFromAttribute($value)
    {
        if ($value) {
            $this->attributes['wednesday_from'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['wednesday_from'] = null;
        }
    }

    /**
     * Get wednesday to
     *
     * @param  string $value
     *
     * @return string
     */
    public function getWednesdayToAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set tuesday from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setWednesdayToAttribute($value)
    {
        if ($value) {
            $this->attributes['wednesday_to'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['wednesday_to'] = null;
        }
    }

    /**
     * Get thursday from
     *
     * @param  string $value
     *
     * @return string
     */
    public function getThursdayFromAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set thursday from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setThursdayFromAttribute($value)
    {
        if ($value) {
            $this->attributes['thursday_from'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['thursday_from'] = null;
        }
    }

    /**
     * Get thursday to
     *
     * @param  string $value
     *
     * @return string
     */
    public function getThursdayToAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set thursday from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setThursdayToAttribute($value)
    {
        if ($value) {
            $this->attributes['thursday_to'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['thursday_to'] = null;
        }
    }

    /**
     * Get friday from
     *
     * @param  string $value
     *
     * @return string
     */
    public function getFridayFromAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set friday from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setFridayFromAttribute($value)
    {
        if ($value) {
            $this->attributes['friday_from'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['friday_from'] = null;
        }
    }

    /**
     * Get friday to
     *
     * @param  string $value
     *
     * @return string
     */
    public function getFridayToAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set friday to
     *
     * @param  string $value
     *
     * @return void
     */
    public function setFridayToAttribute($value)
    {
        if ($value) {
            $this->attributes['friday_to'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['friday_to'] = null;
        }
    }

    /**
     * Get saturday from
     *
     * @param  string $value
     *
     * @return string
     */
    public function getSaturdayFromAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set saturday from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setSaturdayFromAttribute($value)
    {
        if ($value) {
            $this->attributes['saturday_from'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['saturday_from'] = null;
        }
    }

    /**
     * Get saturday to
     *
     * @param  string $value
     *
     * @return string
     */
    public function getSaturdayToAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set saturday to
     *
     * @param  string $value
     *
     * @return void
     */
    public function setSaturdayToAttribute($value)
    {
        if ($value) {
            $this->attributes['saturday_to'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['saturday_to'] = null;
        }
    }

    /**
     * Get sunday from
     *
     * @param  string $value
     *
     * @return string
     */
    public function getSundayFromAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set sunday from
     *
     * @param  string $value
     *
     * @return void
     */
    public function setSundayFromAttribute($value)
    {
        if ($value) {
            $this->attributes['sunday_from'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['sunday_from'] = null;
        }
    }

    /**
     * Get sunday to
     *
     * @param  string $value
     *
     * @return string
     */
    public function getSundayToAttribute($value)
    {
        if (!$value) {
            return $value;
        }

        return Carbon::createFromFormat('H:i:s', $value)->format('H:i');
    }

    /**
     * Set sunday to
     *
     * @param  string $value
     *
     * @return void
     */
    public function setSundayToAttribute($value)
    {
        if ($value) {
            $this->attributes['sunday_to'] = Carbon::parse($value)->format('H:i:s');
        } else {
            $this->attributes['sunday_to'] = null;
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
