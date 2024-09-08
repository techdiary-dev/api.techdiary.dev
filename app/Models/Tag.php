<?php

namespace App\Models;

use App\TechDiary\HasMetaData;
use App\TechDiary\Reaction\Traits\ReactionableModel;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory, HasMetaData, ReactionableModel;
    use HasUuids;

    protected $casts = [
        'id' => 'string',
    ];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    protected $guarded = ['id'];

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
