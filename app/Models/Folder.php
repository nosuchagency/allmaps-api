<?php

namespace App\Models;

use App\Models\Content\Content;
use App\Models\Content\FileContent;
use App\Models\Content\GalleryContent;
use App\Models\Content\ImageContent;
use App\Models\Content\TextContent;
use App\Models\Content\VideoContent;
use App\Models\Content\WebContent;
use App\Traits\HasCategory;
use App\Traits\HasCreatedBy;
use App\Traits\HasRelations;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Folder extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, LogsActivity, SoftCascadeTrait;

    /**
     * @var string
     */
    protected $table = 'content_folders';

    /**
     * @var array
     */
    protected $softCascade = [
        'contents'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'primary',
        'container_id',
        'order',
        'created_by',
        'category_id',
        'category'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'primary' => 'boolean'
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
     * Model Relations
     *
     * @var array
     */
    public $relationships = [
        'tags',
        'contents',
        'images',
        'videos',
        'files',
        'galleries',
        'texts',
        'web'
    ];

    /**
     * Get the content that owns the folder.
     */
    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    /**
     * The tags that belong to the folder
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_folder');
    }

    /**
     * Get the contents for the folder.
     */
    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    /**
     * Get the images for the folder.
     */
    public function images()
    {
        return $this->hasMany(ImageContent::class);
    }

    /**
     * Get the videos for the folder.
     */
    public function videos()
    {
        return $this->hasMany(VideoContent::class);
    }

    /**
     * Get the files for the folder.
     */
    public function files()
    {
        return $this->hasMany(FileContent::class);
    }

    /**
     * Get the galleries for the folder.
     */
    public function galleries()
    {
        return $this->hasMany(GalleryContent::class);
    }

    /**
     * Get the texts for the folder.
     */
    public function texts()
    {
        return $this->hasMany(TextContent::class);
    }

    /**
     * Get the web links for the folder.
     */
    public function web()
    {
        return $this->hasMany(WebContent::class);
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePrimary($query)
    {
        return $query->where('primary', true);
    }

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order');
        });
    }
}
