<?php

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhotoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    public function test_index_show_latest_photos()
    {
        User::factory()->create();
        $photo = Photo::factory()->create();

        $response = $this->get('/photos');
        $response->assertStatus(200)
            ->assertSee($photo->title)
            ->assertSee($photo->description)
            ->assertSee($photo->image);

        $this->assertDatabaseHas('photos', [
            'id' => $photo->id,
            'title' => $photo->title,
            'description' => $photo->description,
            'image' => $photo->image,
        ]);
    }

    public function test_index_empty()
    {
        $response = $this->get('/photos');
        $response->assertStatus(200)
            ->assertSee('Nothing to see here.');

        $this->assertDatabaseMissing('photos', []);
    }
}
