<?php
use App\Models\Article;
use App\Models\User;


test('Reaction: model->storeReaction()', function () {
    $user = User::factory()->create();
    $article = $user->articles()->create(['title' => 'article']);

    // have reactions relations
    $this->assertCount(0, $article->reactions);


    $type = 'TEST_REACTION';

    $reaction = $article->storeReaction($type, $user);
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


    $article = Article::create(['title' => 'article', 'user_id' => User::all()->random()->id]);


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


    $article = Article::create(['title' => 'article', 'user_id' => User::all()->random()->id]);
    $comment = $article->comments()->create(['body' => 'comment', 'user_id' => User::all()->random()->id]);


    $comment->storeReaction('SAVED', $user1);
    $comment->storeReaction('SAVED', $user2);
    $comment->storeReaction('SAVED', $user3);
    $comment->storeReaction('SAVED', $user4);
    $comment->storeReaction('SAVED', $user5);

    $reactorIds = $comment->reactorIds();

    $this->assertTrue($reactorIds->contains($user1->id));
    $this->assertTrue($reactorIds->contains($user2->id));
    $this->assertTrue($reactorIds->contains($user3->id));
    $this->assertTrue($reactorIds->contains($user4->id));
    $this->assertTrue($reactorIds->contains($user5->id));

    $this->assertCount(5, $reactorIds);
});


//test('Reaction: model->reactorIds() to Tag model', function () {
//
//}
