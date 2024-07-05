<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\User;
use App\Models\Board;

class B05BoardImageTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * @test
     */
    public function testCreateBoardSuccessWhenLoggedIn()
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        $attributes = [
            'title' => 'test title',
            'description' => 'test description',
            'image' => UploadedFile::fake()->image('test.png')
        ];

        $response = $this->post('/boards', $attributes);

        $response->assertStatus(302);
        $response->assertRedirect('/boards');

        $board = Board::where('title', $attributes['title'])->first();
        Storage::disk('public')->assertExists($board->image_path);
    }
}
