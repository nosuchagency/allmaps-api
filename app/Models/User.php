<?php

namespace App\Models;

use App\Filters\IndexFilter;
use App\Models\Content\Content;
use App\Notifications\ResetPasswordNotification;
use App\Traits\HasCategory;
use App\Traits\HasRelations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use HasRelations, HasCategory, Notifiable, HasRoles, CausesActivity, LogsActivity;

    /**
     * @var string
     */
    protected $guard_name = 'api';

    /**
     * @var array
     */
    protected static $ignoreChangedAttributes = [
        'remember_token'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'category_id',
        'locale',
        'category'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * Model Relations
     *
     * @var array
     */
    public $relationships = [
        'tags',
        'contents'
    ];

    /**
     * The tags that belong to the user
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tag_user');
    }

    /**s
     * Get the content that the user has created
     */
    public function contents()
    {
        return $this->hasMany(Content::class, 'created_by');
    }

    /**
     * @return string
     */
    public function getInvitationLink()
    {
        return 'https://link.com?token=' . Str::random(30);
    }

    /**
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * @param int $count
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Support\Collection
     */
    public function recentActions($count = 20)
    {
        return $this->actions()->orderBy('id', 'desc')->take($count)->get();
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
     * Send the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
    
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
