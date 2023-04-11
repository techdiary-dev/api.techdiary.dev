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
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Scout\Searchable;

/**
 * App\Models\Article
 *
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string|null $thumbnail
 * @property string|null $seriesName
 * @property array $body
 * @property string|null $excerpt
 * @property bool $isPublished
 * @property bool $isApproved
 * @property string $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TechDiary\Reaction\Model\Reaction[] $reactions
 * @property-read int|null $reactions_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User $user
 *
 * @method static \Database\Factories\ArticleFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Article query()
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereIsPublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSeriesName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Article withScopes($scopes = [])
 *
 * @mixin \Eloquent
 */
class Article extends Model implements ReactableInterface
{
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
