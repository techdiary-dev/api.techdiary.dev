<?php

test('bookmark an article', function () {
    $this->actingAs(\App\Models\User::factory()->create());

    $article = auth()->user()->articles()->create();

    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->post('/api/bookmarks', [
            'model_name' => 'ARTICLE',
            'model_id' => $article->id
        ]);

    $response->assertSuccessful();
});

test('bookmark a tag', function () {
    $this->actingAs(\App\Models\User::factory()->create());

    $tag = \App\Models\Tag::create(['name' => 'tag']);

    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->post('/api/bookmarks', [
            'model_name' => 'TAG',
            'model_id' => $tag->id
        ]);

    $response->assertOk();
});


test('Failed bookmark a tag without auth', function () {
    $tag = \App\Models\Tag::create(['name' => 'tag']);

    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->post('/api/bookmarks', [
            'model_name' => 'TAG',
            'model_id' => $tag->id
        ]);

    $response->assertStatus(401)
        ->assertExactJson([
            'message' => 'Unauthenticated.'
        ]);
});


//test('List of bookmarked articles', function () {
//    $this->actingAs(\App\Models\User::factory()->create());
//
//    $article1 = \App\Models\Article::create(['user_id' => \App\Models\User::factory()->create()->id]);
//    $article2 = \App\Models\Article::create(['user_id' => \App\Models\User::factory()->create()->id]);
//    $article3 = \App\Models\Article::create(['user_id' => \App\Models\User::factory()->create()->id]);
//
//    $article1->storeReaction(ReactionableModelTest'BOOKMARK', auth()->user());
//    $article2->storeReaction('BOOKMARK', auth()->user());
//    $article3->storeReaction('BOOKMARK', auth()->user());
//
//
//    $response = $this->get('api/bookmarks?model_name=ARTICLE');
//    $response->assertOk();
//
//    $response->assertJsonCount(3, 'data');
//});


test('List of bookmarked tags', function () {
    $this->actingAs(\App\Models\User::factory()->create());

    $tag1 = \App\Models\Tag::create(['name' => 'tag1']);
    $tag2 = \App\Models\Tag::create(['name' => 'tag2']);
    $tag3 = \App\Models\Tag::create(['name' => 'tag3']);

    $tag1->storeReaction('BOOKMARK', auth()->user());
    $tag2->storeReaction('BOOKMARK', auth()->user());
    $tag3->storeReaction('BOOKMARK', auth()->user());


    $response = $this->get('api/bookmarks?model_name=TAG');
    $response->assertOk();

    $response->assertJsonCount(3, 'data');
});
