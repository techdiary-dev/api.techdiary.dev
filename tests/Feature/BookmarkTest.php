<?php

use App\Models\Article;
use App\Models\User;

//test('POST api/bookmarks: Bookmark an article', function () {
//    $user = User::factory()->create();
//    $token = $user->createToken('token');
//    $article = Article::factory()->create();
//
//    $response = $this->post('/api/bookmarks', [
//        'model_name' => 'ARTICLE',
//        'model_id' => $article->id
//    ], ['Authorization' => 'Bearer ' . $token->plainTextToken]);
//
//    $response->assertOk();
//});

//test('POST api/bookmarks: Bookmark a comment', function () {
//    $user = User::factory()->create();
//    $token = $user->createToken('token');
//    $article = Article::factory()->create();
//    $comment = $article->comments()->create([
//        'body' => 'commentText',
//        'user_id' => $user->id
//    ]);
//
////    dump($comment);
////
//    $response = $this->post('/api/bookmarks', [
//        'model_name' => 'COMMENT',
//        'model_id' => $comment->id
//    ], ['Authorization' => 'Bearer ' . $token->plainTextToken]);
//
//    $response->assertOk();
//});
