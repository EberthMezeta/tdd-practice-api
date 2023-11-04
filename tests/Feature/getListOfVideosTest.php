<?php

use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;

use function PHPUnit\Framework\assertJson;

uses(RefreshDatabase::class);

test('get list of videos', function () {

    //create a 5 videos
    $videos = Video::factory()->count(3)->create();
    //call the API
    $response =  $this->get('/api/videos')->assertOk()->assertJsonCount(3);
    //validate that videos are in the response

});


test('payload has the JSON', function () {



    $unThumbnail = 'http:imagen.com';

    //create a 5 videos
    $video = Video::factory()->create(
        [
            'thumbnail' => $unThumbnail
        ]

    );

    $unId = $video->id;
    //call the API
    $this->get('/api/videos')->assertExactJson([
        [
            'id' => $unId,
            'thumbnail' => $unThumbnail
        ]
    ]);
    //validate that videos are in the response

});


test('List of video newest to oldest', function () {

    //create a 3 videos

    $videoFromOneMount = Video::factory()->create(['created_at' => Carbon::now()->subDays(30)]);

    $videoYesterday = Video::factory()->create(['created_at' => Carbon::yesterday()]);

    $videoToday =  Video::factory()->create(['created_at' => Carbon::now()]);
    //call the API and validate that videos are in the response
    $this->getJson('/api/videos')->assertJsonPath('0.id', $videoToday->id)->assertJsonPath('1.id', $videoYesterday->id)->assertJsonPath('2.id', $videoFromOneMount->id);
});

test('Validate the limite of the videos by query', function () {

    //create a 5 videos
    Video::factory()->count(10)->create();
    //call the API
    $this->get('/api/videos?limit=3')->assertJsonCount(3);
    //validate that videos are in the response

});


test('Validate the unprocessable limit of the videos by query when is a string', function () {

    //create a 5 videos
    Video::factory()->count(4)->create();
    //call the API
    $this->get('/api/videos?limit=unstring')->assertStatus(Response::HTTP_FOUND);
    //validate that videos are in the response


});

test('Validate the limit in 30', function () {

    //create a 5 videos
    Video::factory()->count(40)->create();
    //call the API
    $this->get('/api/videos')->assertJsonCount(30);
    //validate that videos are in the response

});

test('Validate the max limit of videos', function () {

    //create a 5 videos
    Video::factory()->count(51)->create();
    //call the API
    $this->get('/api/videos?limit=51')->assertStatus(Response::HTTP_FOUND);
    //validate that videos are in the response
});

test('Validate the minimum limit of videos', function () {

    //create a 5 videos
    Video::factory()->count(3)->create();
    //call the API
    $this->get('/api/videos?limit=0')->assertStatus(Response::HTTP_FOUND);
    //validate that videos are in the response
});

//Another form to testing any escenaries is way from datasets, for example, some tests has the same code but change 
//some parameters, so we can use datasets

/*
test('limit values of the query parameter string', function ($videosToCreate,  $valueLimit) {

    Video::factory()->count($videosToCreate)->create();
    $this->get('/api/videos?=' . $valueLimit)->assertStatus(Response::HTTP_FOUND);
})->with([4])->with([51, 0, 'string']);
*/

test('Can paginate the page', function () {

    Video::factory()->count(9)->create();
    //call the API
    $this->get('/api/videos?limit=5&page=2')->assertJsonCount(4);
});


test('Page 1 is the first', function () {

    Video::factory()->count(9)->create();
    //call the API
    $this->get('/api/videos?limit=5')->assertJsonCount(5);
});


test('API return 0 when the page no exist', function () {

    Video::factory()->count(9)->create();
    //call the API
    $this->get('/api/videos?limit=5&page=20')->assertJsonCount(0);
});



test('API return 302 when the limit is wrong', function () {

    //call the API
    $this->get('/api/videos?page=str')->assertStatus(Response::HTTP_FOUND);
});
