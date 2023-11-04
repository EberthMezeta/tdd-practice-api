<?php

use App\Models\Serie;
use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
test('get list of series', function () {

    Serie::factory()->count(2)->create();

    $this->getJson('/api/series')->assertOk()->assertJsonCount(2);
});

test('The previwe has the format correct', function () {


    $serie = Serie::factory()->create();

    $this->getJson('/api/series')->assertExactJson([
        [
            'id' => $serie->id,
            'title' => $serie->title,
            'thumbnail' => $serie->thumbnail,
            'resumen' => $serie->resumen,
        ]
    ]);
});

test('Videos of the series can be obtein', function () {

    Video::factory()->create();
    $serie = Serie::factory()->create();
    $serie->videos()->attach(
        Video::factory()->count(2)->create()->pluck('id')->toArray()
    );
    $this->getJson(sprintf('/api/series/%s/videos', $serie->id))->assertOk()->assertJsonCount(2);
});


test('The content of the video is correct   ', function () {

    $video = Video::factory()->create();
    $serie = Serie::factory()->create();
    $serie->videos()->attach(
        $video->id
    );
    $this->getJson(sprintf('/api/series/%s/videos', $serie->id))->assertOk()->assertExactJson([[
        'id' => $video->id,
        'thumbnail' => $video->thumbnail
    ]]);
});
