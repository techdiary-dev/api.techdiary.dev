<?php

namespace App\Models;

use App\Http\Resources\Article\ArticleList;
use App\TechDiary\Reaction\Contracts\ReactableInterface;
use App\TechDiary\Reaction\Traits\ReactionableModel;
use App\Traits\CanBeScoped;
use App\Traits\NestableComments;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

class Article extends Model implements ReactableInterface
{
    use HasFactory, CanBeScoped, Searchable, ReactionableModel, NestableComments;

    protected $guarded = ['isApproved'];
    protected $casts = [
        'body' => 'array',
        'id' => 'string'
    ];
    protected $primaryKey = 'id';
    protected $keyType = 'string';

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function ($article) {

            if (!$article->slug) {
                $article->slug = Str::slug($article->title) . '-' . Str::random(6);
            }
        });
    }

    /**
     * Define article payload for algolia search
     * @return array
     */
    public function toSearchableArray()
    {
        return ArticleList::make($this->load('tags'))->jsonSerialize();
    }

    /**
     * Defined what object should be searchable
     * @return mixed
     */
    public function shouldBeSearchable()
    {
        return $this->isPublished;
    }
}
