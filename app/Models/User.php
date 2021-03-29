<?php

namespace App\Models;

use App\TechDiary\Reaction\Traits\ReactorUserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;

    use HasFactory, Notifiable, HasApiTokens, ReactorUserModel;

    protected $keyType = 'string';
    protected $primaryKey = 'id';
//    public $identifiableAttribute = 'service_uid';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'social_links' => 'array',
        'id' => 'string'
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function socialProviders()
    {
        return $this->hasMany(UserSocial::class);
    }

    public function bookmarkedArticles()
    {
        return $this->hasMany(Bookmark::class)
            ->where('bookmarkAble_type', Article::class);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function series()
    {
        return $this->hasMany(Series::class);
    }

//    public function isOnline()
//    {
//        return Cache::has('user-is-online-' . $this->id);
//    }
}
