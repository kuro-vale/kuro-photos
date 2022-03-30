<?php

namespace Tests\Feature;

use App\Models\Photo;
use App\Models\User;
use Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Storage;
use Tests\TestCase;

class PhotoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // Index Test

    public function test_photo_index_show_latest_photos()
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

    public function test_photo_index_empty()
    {
        $response = $this->get('/photos');
        $response->assertStatus(200)
            ->assertSee('Nothing to see here.');

        $this->assertDatabaseMissing('photos', []);
    }

    // Create photos test

    public function test_create_photo_return_200_but_guest_redirect_to_login()
    {
        $response = $this->get('/photos/create');
        $response->assertRedirect('login');

        $user = User::factory()->create();

        Auth::login($user);

        $response = $this->get('/photos/create');
        $response->assertStatus(200);
    }

    public function test_store_photo()
    {
        $user = User::factory()->create();
        Auth::login($user);
        Storage::fake('public');
        $data = [
            'title' => 'Test title',
            'description' => $this->faker->text(),
            'image' => UploadedFile::fake()->image('test.png'),
        ];

        $response = $this->post('/photos', $data);
        $response->assertRedirect('/photos/1');

        $this->assertDatabaseHas('photos', [
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => 'photos/' . $data['image']->hashName()
        ]);

        Storage::disk('public')->assertExists("photos/" . $data['image']->hashName());
    }

    public function test_validate_store_photo()
    {
        $user = User::factory()->create();
        Auth::login($user);
        $data = [
            'title' => $this->faker->text(666),
            'image' => UploadedFile::fake()->create('notanimage.php')
        ];

        $response = $this->post('/photos', $data);
        $response->assertStatus(302)
            ->assertSessionHasErrors(['title', 'description', 'image']);
    }

    // Show photo test

    public function test_show_photo()
    {
        User::factory()->create();
        $photo = Photo::factory()->create();

        $response = $this->get("/photos/{$photo->id}");
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

    // Edit photo test

    public function test_edit_photo_return_200_but_guest_redirect_to_login()
    {
        $user = User::factory()->create();
        $photo = Photo::factory()->create();
        $response = $this->get("/photos/{$photo->id}/edit");
        $response->assertRedirect('login');

        Auth::login($user);

        $response = $this->get("/photos/{$photo->id}/edit");
        $response->assertStatus(200);
    }

    public function test_update_photo()
    {
        $user = User::factory()->create();
        $photo = Photo::factory()->create();
        Auth::login($user);
        $data = [
            'title' => 'New title',
            'description' => $this->faker->text(),
        ];

        $response = $this->put("photos/{$photo->id}", $data);
        $response->assertRedirect("photos/{$photo->id}");

        $this->assertDatabaseHas('photos', [
            'title' => $data['title'],
            'description' => $data['description'],
            'image' => $photo->image
        ]);
    }

    public function test_validate_update_photo()
    {
        $user = User::factory()->create();
        $photo = Photo::factory()->create();
        Auth::login($user);

        $response = $this->put("/photos/{$photo->id}", []);
        $response->assertStatus(302)
            ->assertSessionHasErrors(['title', 'description']);
    }

    // Destroy photo test

    public function test_destroy_photo()
    {
        $user = User::factory()->create();
        $photo = Photo::factory()->create();
        Auth::login($user);

        $response = $this->delete("/photos/{$photo->id}");
        $response->assertRedirect('/photos');

        $this->assertDatabaseMissing('photos', [
            'id' => $photo->id,
            'user_id' => $photo->user->id,
            'title' => $photo->title,
            'description' => $photo->description,
            'image' => $photo->image,
        ]);

        Storage::disk('public')->assertMissing($photo->image);
    }
}
