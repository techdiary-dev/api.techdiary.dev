<?php

use App\Models\Article;

test('/api/comments: Comment on article', function () {
    $user = \App\Models\User::factory()->create();
    $this->actingAs($user);

    $article = Article::factory()->create();

    $response = $this->post('/api/comments', [
        'model_name' => 'ARTICLE',
        'model_id' => $article->id,
        'body' => 'This is a comment'
    ]);

    $response->assertOk();
});
