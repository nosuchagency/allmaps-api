<?php

namespace App\Models;

use App\Filters\IndexFilter;
use App\Traits\HasCreatedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Spatie\Activitylog\Traits\LogsActivity;

class Skin extends Model
{
    use HasCreatedBy, LogsActivity;

    /**
     * @var string
     */
    public $dataKey;

    /**
     * Skin constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->dataKey = config('bb.skins.data_key');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mobile',
        'tablet',
        'desktop'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'mobile' => 'boolean',
        'tablet' => 'boolean',
        'desktop' => 'boolean'
    ];

    /**
     * @return string
     */
    public function getBasePath()
    {
        return public_path(config('bb.skins.directory') . $this->identifier);
    }

    /**
     * @return string
     */
    public function getIndexFilePath()
    {
        return $this->getBasePath() . '/index.html';
    }

    /**
     * @return bool
     */
    public function directoryExists()
    {
        if (File::exists($this->getBasePath()) && File::isDirectory($this->getBasePath())) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     */
    public function indexFileExists()
    {
        if (File::exists($this->getIndexFilePath()) && File::isFile($this->getIndexFilePath())) {
            return true;
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getIndexFileContent()
    {
        if ($this->indexFileExists()) {
            return File::get($this->getIndexFilePath());
        }

        return null;
    }

    /**
     * @return bool
     */
    public function removeDirectory()
    {
        if ($this->directoryExists()) {
            return File::deleteDirectory($this->getBasePath());
        }

        return false;
    }

    /**
     * @return string
     */
    public function getDataKey()
    {
        return $this->dataKey;
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
}
