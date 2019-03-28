<?php

namespace App\Models\Content;

use App\Models\Container;
use App\Models\Folder;
use App\Models\Tag;
use App\Traits\HasCategory;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

class Content extends Model
{
    use HasCategory, SoftDeletes, HasCreatedBy, LogsActivity;

    protected $table = 'content';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'image',
        'url',
        'text',
        'yt_url',
        'order',
        'folder_id',
        'container_id',
        'content_id',
        'created_by',
        'category_id',
        'category'
    ];

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
        return $this->belongsTo(Container::class);
    }

    /**
     * Get the content that owns the content.
     */
    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    /**
     * Get the contents for the content.
     */
    public function contents()
    {
        return $this->hasMany(Content::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order');
        });
    }
}
