<?php


// update
// destroy

// index
test('get all tags', function () {
    \App\Models\Tag::create(['name' => 'tag1']);
    \App\Models\Tag::create(['name' => 'tag2']);
    \App\Models\Tag::create(['name' => 'tag3']);

    $response = $this->get('/api/tags');

    $response->assertOk();
    $response->assertSee('tag1');
    $response->assertSee('tag2');
    $response->assertSee('tag3');

    $response->assertJsonCount(3, 'data');

});

test('get articles by tag', function () {
    $tag1 = \App\Models\Tag::create(['name' => 'tag1']);
    $user = \App\Models\User::factory()->create();

    $article1 = \App\Models\Article::create([
        'title' => 'article 1',
        'isPublished' => true,
        'user_id' => $user->id
    ]);
    $article2 = \App\Models\Article::create([
        'title' => 'article 2',
        'isPublished' => true,
        'user_id' => $user->id
    ]);

    $article1->tags()->sync($tag1->id);
    $article2->tags()->sync($tag1->id);


    $response = $this->get('/api/articles?tag=' . $tag1->name);


    $response->assertSee('article 1');
    $response->assertSee('article 2');

    $response->assertJsonCount(2, 'data');

});

test('Failed storing without auth', function () {
    $response = $this->withHeaders(['Accept' => 'application/json'])
        ->post('/api/tags',
            [
                'name' => 'tag_name'
            ]);

    $response->assertStatus(401)
        ->assertExactJson([
            'message' => 'Unauthenticated.'
        ]);
});

test('storing tag by authenticated user', function () {
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user);

    $response = $this->post('/api/tags', [
        'name' => 'tag1'
    ]);

    $response->assertSee('tag1');
});
