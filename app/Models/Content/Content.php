<?php

namespace App\Models\Content;

use App\Filters\IndexFilter;
use App\Models\Container;
use App\Models\Folder;
use App\Models\Tag;
use App\Scopes\HasContentParentScope;
use App\Scopes\OrderScope;
use App\Traits\HasCategory;
use App\Traits\HasCreatedBy;
use App\Traits\HasImage;
use App\Traits\HasRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Parental\HasChildren;
use Spatie\Activitylog\Traits\LogsActivity;

class Content extends Model
{
    use HasRelations, HasCategory, SoftDeletes, HasCreatedBy, LogsActivity, HasChildren, HasImage;

    const IMAGE_DIRECTORY_PATH = 'uploads/contents';

    /**
     * @var array
     */
    protected $childTypes = [
        'file' => FileContent::class,
        'gallery' => GalleryContent::class,
        'image' => ImageContent::class,
        'text' => TextContent::class,
        'video' => VideoContent::class,
        'web' => WebContent::class
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    /**
     * Model Relations
     *
     * @var array
     */
    public $relationships = [
        'tags'
    ];

    /**
     * The tags that belong to the content
     */
    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'tag_content',
            'content_id',
            'tag_id'
        );
    }

    /**
     * Get the content that owns the folder.
     */
    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    /**
     * Get the content that owns the folder.
     */
    public function container()
    {
        return $this->belongsTo(Container::class, 'container_id');
    }

    /**
     * Get the content that owns the content.
     */
    public function content()
    {
        return $this->belongsTo(Content::class, 'container_id');
    }

    /**
     * Get the contents for the content.
     */
    public function contents()
    {
        return $this->hasMany(Content::class)
            ->withoutGlobalScope(new HasContentParentScope());
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new OrderScope());
        static::addGlobalScope(new HasContentParentScope());
    }

    /**
     * Process filters
     *
     * @param Builder $builder
     * @param $request
     *
     * @return Builder $builder
     */
    public function scopeFilter(Builder $builder, $request)
    {
        return (new IndexFilter($request))->filter($builder);
    }

    /**
     * @return string
     */
    public function getFileUrl()
    {
        return $this->file ? url('/storage/' . $this->file) : null;
    }
}
