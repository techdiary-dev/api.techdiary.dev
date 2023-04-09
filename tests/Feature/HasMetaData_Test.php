<?php

use App\Models\Tag;

test('Set meta value to tag model', function () {
    $tag = Tag::create(['name' => 'tag1']);

    $tag->setMetaValue('x', 10);
    $tag->setMetaValue('y', 20);

    $this->assertEquals($tag->getMetaValue('x'), 10);
    $this->assertEquals($tag->getMetaValue('y'), 20);
});

test('Meta value will update for same value', function () {
    $tag = Tag::create(['name' => 'tag1']);

    $tag->setMetaValue('x', 10);
    $this->assertEquals($tag->getMetaValue('x'), 10);

    $tag->setMetaValue('x', 20);
    $this->assertEquals($tag->getMetaValue('x'), 20);
});

test('return null from getMetaValue for unknown key', function () {
    $tag = Tag::create(['name' => 'tag1']);
    $this->assertNull($tag->getMetaValue('unknown'));
});

test('set json value to tag model', function () {
    $tag = Tag::create(['name' => 'tag1']);

    $tag->setMetaJSON('seo', [
        'og_image' => 'image',
        'title' => 'title',
    ]);

    $this->assertEquals($tag->getMetaJSON('seo')->og_image, 'image');
    $this->assertEquals($tag->getMetaJSON('seo')->title, 'title');
});
