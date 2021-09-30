<?php


test('up vote on article', function () {
    $this->actingAs(\App\Models\User::factory()->create());

    $article = auth()->user()->articles()->create();

    $article->vote('UP_VOTE', auth()->user());
    $this->assertArrayHasKey('UP_VOTE', collect($article->reactionSummary())->toArray());

});


test('down vote on article', function () {
    $this->actingAs(\App\Models\User::factory()->create());

    $article = auth()->user()->articles()->create();

    $article->vote('DOWN_VOTE', auth()->user());
    $this->assertArrayHasKey('DOWN_VOTE', collect($article->reactionSummary())->toArray());
});


test('remove up_vote if already exists on article', function () {
    $this->actingAs(\App\Models\User::factory()->create());

    $article = auth()->user()->articles()->create();

    $article->vote('UP_VOTE', auth()->user());
    $this->assertArrayHasKey('UP_VOTE', collect($article->reactionSummary())->toArray());

    $article->vote('UP_VOTE', auth()->user());
    $this->assertArrayNotHasKey('UP_VOTE', collect($article->reactionSummary())->toArray());

});

test('remove down_vote if already exists on article', function () {
    $this->actingAs(\App\Models\User::factory()->create());

    $article = auth()->user()->articles()->create();

    $article->vote('DOWN_VOTE', auth()->user());
    $this->assertArrayHasKey('DOWN_VOTE', collect($article->reactionSummary())->toArray());

    $article->vote('DOWN_VOTE', auth()->user());
    $this->assertArrayNotHasKey('DOWN_VOTE', collect($article->reactionSummary())->toArray());
});

test('count 2 up_votes for two different users on articles', function () {
    $user1 = \App\Models\User::factory()->create();
    $user2 = \App\Models\User::factory()->create();

    $article = \App\Models\Article::create(['user_id' => \App\Models\User::all()->random()->id]);

    $article->vote('UP_VOTE', $user1);
    $article->vote('UP_VOTE', $user2);

    $summery = collect($article->reactionSummary())->toArray();

    $this->assertArrayHasKey('UP_VOTE', $summery);
    $this->assertCount(2, $summery['UP_VOTE']['reactors']);
});
