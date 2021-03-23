<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


class ArticleFactory extends Factory
{

    protected $commentCount = 10;
    protected $commentDeptLevel = 3;


    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence;

        $body = [
            ["type" => "paragraph", "data" => ["text" => "Dummy paragraph content"]]
        ];

        return [
            'title' => $title,
            'slug' => Str::slug($title) . '-' . Str::random(6),
            'thumbnail' => $this->faker->imageUrl(700, 450),
            'body' => $body,
            'isPublished' => $this->faker->boolean,
            'isApproved' => true,
            'user_id' => User::all()->random()->id
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Article $article) {
            $comments = Comment::factory($this->commentCount)->for(
                $article, 'commentable'
            )->create()->each(function ($comment) use ($article) {
                $comment->replies()->saveMany($this->createComments($comment, $article, $this->commentDeptLevel));
            });
            $article->comments()->saveMany($comments);
        });
    }

    protected function createComments($comment, $article, $depth = 3, $currentDepth = 0)
    {
        if ($currentDepth === $depth) {
            return;
        }
        return $comment->replies()->saveMany(Comment::factory(3)->for(
            $article, 'commentable'
        )->create()->each(function ($reply) use ($depth, $article, $currentDepth) {
            $article->comments()->save($reply);
            $this->createComments($reply, $article, $depth, ++$currentDepth);
        }));
    }
}
