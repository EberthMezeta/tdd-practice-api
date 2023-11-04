<?php

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

use App\Models\Fruit;

it('The endpoint return a fruit by id', function () {

    $fruit = Fruit::factory()->create();
    $response = $this->get(sprintf('/api/fruits/%s', $fruit->id));
    $response->assertJsonFragment($fruit->toArray());
});
