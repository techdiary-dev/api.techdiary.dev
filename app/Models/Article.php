<?php

namespace App\Models;

use App\Http\Resources\Article\ArticleList;
use App\TechDiary\HasComments;
use App\TechDiary\HasMetaData;
use App\TechDiary\Markdown\TDMarkdown;
use App\TechDiary\Reaction\Contracts\ReactableInterface;
use App\TechDiary\Reaction\Traits\ReactionableModel;
use App\TechDiary\VotableModel;
use App\Traits\CanBeScoped;
use App\Traits\NestableComments;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;


class Article extends Model implements ReactableInterface
{
    use HasUuids;
    use HasFactory, CanBeScoped, ReactionableModel, HasComments, NestableComments, HasMetaData, VotableModel;

//    protected $guarded = ['isApproved'];
    protected $guarded = ['user_id'];

    protected $casts = [
        'id' => 'string',
    ];

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
//        static::creating(function ($article) {
//
//            if (!$article->slug) {
//                $article->slug = Str::slug($article->title) . '-' . Str::random(6);
//            }
//        });
    }

    /**
     * Define article payload for algolia search
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return ArticleList::make($this->load('tags'))->jsonSerialize();
    }

    public function setSlugAttribute($slug)
    {
        if ($slug) {
            $this->attributes['slug'] = Str::slug($slug).'-'.Str::random(6);
        } else {
            $this->attributes['slug'] = $this->attributes['id'];
        }
    }

    /**
     * Defined what object should be searchable
     *
     * @return mixed
     */
    public function shouldBeSearchable()
    {
        return $this->isPublished;
    }

    public function openGoogle($crud = false)
    {
        return '<a href='.env('CLIENT_BASE_URL').'/'.$this->user->username.'/'.$this->slug.'>Read</a>';
    }

    public function getBodyHtmlAttribute()
    {
        $md = new TDMarkdown($this->body);

        return $md->toHTML();
    }

    public function getUrlAttribute()
    {
        return env('CLIENT_BASE_URL').'/'.$this->user->username.'/'.$this->slug;
    }
}
