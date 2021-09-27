<?php
use App\Models\Article;
use App\Models\User;


test('Reaction: model->storeReaction()', function () {
    $this->actingAs(User::factory()->create());

    $article = auth()->user()->articles()->create(['title' => 'article']);

    // have reactions relations
    $this->assertCount(0, $article->reactions);


    $type = 'TEST_REACTION';

    $reaction = $article->storeReaction($type, auth()->user());
    $this->assertEquals($type, $reaction->type);
});

/**
 * Check list of user ids who are reacted to a model
 */
test('Reaction: model->reactorIds() to Article Model', function () {

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();
    $user4 = User::factory()->create();
    $user5 = User::factory()->create();

    $this->actingAs($user1);


    $article = auth()->user()->articles()->create(['title' => 'article']);


    $article->storeReaction('SAVED', $user1);
    $article->storeReaction('SAVED', $user2);
    $article->storeReaction('SAVED', $user3);
    $article->storeReaction('SAVED', $user4);
    $article->storeReaction('SAVED', $user5);

    $reactorIds = $article->reactorIds();


    $this->assertTrue($reactorIds->contains($user1->id));
    $this->assertTrue($reactorIds->contains($user2->id));
    $this->assertTrue($reactorIds->contains($user3->id));
    $this->assertTrue($reactorIds->contains($user4->id));
    $this->assertTrue($reactorIds->contains($user5->id));

    $this->assertCount(5, $reactorIds);
});


test('Reaction: model->reactorIds() to Comment Model', function () {

    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();
    $user4 = User::factory()->create();
    $user5 = User::factory()->create();

    $this->actingAs($user1);


    $article = Article::create(['title' => 'article', 'user_id' => User::all()->random()->id]);
    $comment = $article->comments()->create(['body' => 'comment', 'user_id' => User::all()->random()->id]);


    $comment->storeReaction('BOOKMARK', $user1);
    $comment->storeReaction('BOOKMARK', $user2);
    $comment->storeReaction('BOOKMARK', $user3);
    $comment->storeReaction('BOOKMARK', $user4);
    $comment->storeReaction('BOOKMARK', $user5);

    $reactorIds = $comment->reactorIds();

    $this->assertTrue($reactorIds->contains($user1->id));
    $this->assertTrue($reactorIds->contains($user2->id));
    $this->assertTrue($reactorIds->contains($user3->id));
    $this->assertTrue($reactorIds->contains($user4->id));
    $this->assertTrue($reactorIds->contains($user5->id));

    $this->assertCount(5, $reactorIds);
});


test('Reaction: model->reactionsBy() to Article Model', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();

    $this->actingAs($user1);

    $article = auth()->user()->articles()->create(['title' => 'article']);

    $article->storeReaction('BOOKMARK', auth()->user());
    $article->storeReaction('BOOKMARK', $user2);
    $article->storeReaction('BOOKMARK', $user3);

    $this->assertCount(3, $article->reactionsBy());
});


test('Reaction: model->reactionSummary() to Article Model', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();

    $this->actingAs($user1);

    $article = auth()->user()->articles()->create(['title' => 'article']);
    $article->storeReaction('BOOKMARK', auth()->user());
    $article->storeReaction('SAVED', $user2);
    $article->storeReaction('HEART', $user3);


    $this->assertArrayHasKey('BOOKMARK', collect($article->reactionSummary())->toArray());
    $this->assertArrayHasKey('SAVED', collect($article->reactionSummary())->toArray());
    $this->assertArrayHasKey('HEART', collect($article->reactionSummary())->toArray());

});


test('Reaction: model->isReactBy() to Tag Model', function () {
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();

    $this->actingAs($user1);

    $tag = \App\Models\Tag::create(['name' => 'tag']);
    $tag->storeReaction('BOOKMARK', auth()->user());
    $tag->storeReaction('SAVED', auth()->user());
    $tag->storeReaction('HEART', auth()->user());

    $this->assertTrue($tag->isReactBy(auth()->user()));
    $this->assertTrue($tag->isReactBy(auth()->user(), 'BOOKMARK'));
    $this->assertTrue($tag->isReactBy(auth()->user(), 'SAVED'));
    $this->assertTrue($tag->isReactBy(auth()->user(), 'HEART'));

    $this->assertFalse($tag->isReactBy($user2));
    $this->assertFalse($tag->isReactBy($user2), 'HEYYYY');
});

test('Reaction: model->removeReaction() to Tag Model', function () {
    $user1 = User::factory()->create();

    $this->actingAs($user1);

    $tag = \App\Models\Tag::create(['name' => 'tag']);
    $tag->storeReaction('BOOKMARK', auth()->user());
    $tag->storeReaction('SAVED', auth()->user());
    $tag->storeReaction('HEART', auth()->user());

    $this->assertTrue($tag->removeReaction('BOOKMARK', auth()->user()));
    $this->assertFalse($tag->removeReaction('BOOKMARK', auth()->user()));
    $this->assertFalse($tag->removeReaction('NOTHING', auth()->user()));
});


test('Reaction: model->toggleReaction() to Tag Model', function () {
    $this->actingAs(User::factory()->create());

    $tag = \App\Models\Tag::create(['name' => 'tag']);
    $tag->storeReaction('BOOKMARK', auth()->user());

    $this->assertArrayHasKey('BOOKMARK', collect($tag->reactionSummary())->toArray());

    $tag->toggleReaction('BOOKMARK', auth()->user());

    $this->assertArrayNotHasKey('BOOKMARK', collect($tag->reactionSummary())->toArray());

    $tag->toggleReaction('BOOKMARK', auth()->user());

    $this->assertArrayHasKey('BOOKMARK', collect($tag->reactionSummary())->toArray());
});
