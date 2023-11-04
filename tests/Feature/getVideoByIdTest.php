<?php

use App\Models\Video;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);



test('getVideoById', function () {


    $video = Video::factory()->create();
    //Call the API
    $response = $this->get(sprintf('/api/videos/%s', $video->id));
    //Validate 
    $response->assertJsonFragment($video->toArray());
});
