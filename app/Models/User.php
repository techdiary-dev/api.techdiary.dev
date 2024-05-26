<?php

namespace App\Models;

use App\TechDiary\Reaction\Contracts\ReactorUserInterface;
use App\TechDiary\Reaction\Model\Reaction;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements ReactorUserInterface
{
    use TwoFactorAuthenticatable;
    use HasUuids;
    use HasFactory, Notifiable, HasApiTokens;

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
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'social_links' => 'array',
        'id' => 'string',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function socialProviders()
    {
        return $this->hasMany(UserSocial::class);
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = Str::slug(strtolower($value));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    // public function setPasswordAttribute($password)
    // {
    //     if ($password) {
    //         $this->setAttribute('password', bcrypt($password));
    //     }
    // }
}
