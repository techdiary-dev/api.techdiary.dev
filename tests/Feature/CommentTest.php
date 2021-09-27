<?php

use App\Models\Article;

test('/api/comments: Comment on article', function () {
    $user = \App\Models\User::factory()->create();
    $token = $user->createToken('token');

    $article = Article::factory()->create();

    $response = $this->post('/api/comments', [
        'model_name' => 'ARTICLE',
        'model_id' => $article->id,
        'body' => 'This is a comment'
    ], [
        'Authorization' => 'Bearer ' . $token->plainTextToken
    ]);

    $response->assertOk();
    $this->assertCount(1, $article->comments);
});
