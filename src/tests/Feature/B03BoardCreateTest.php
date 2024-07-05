<?php

namespace Tests\Feature;

use App\Models\Board;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class B03BoardCreateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_cannot_create_a_board()
    {
        $response = $this->get('/boards/create');

        $response->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_view_the_create_board_page()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->get('/boards/create');

        $response->assertStatus(200);
    }

    /** @test */
    public function a_board_can_be_created()
    {
        $user = \App\Models\User::factory()->create();
        $attributes = [
            'title' => 'Test Board',
            'description' => 'This is a test board',
        ];

        $this->actingAs($user)->post('/boards', $attributes);

        $this->assertDatabaseHas('boards', $attributes);
    }

    /** @test */
    public function a_board_title_is_required_to_create_a_board()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->post('/boards', [
            'description' => 'This is a test board',
        ]);

        $response->assertSessionHasErrors('title');
        $this->assertDatabaseCount('boards', 0);
    }

    /** @test */
    public function a_board_description_is_required_to_create_a_board()
    {
        $user = \App\Models\User::factory()->create();

        $response = $this->actingAs($user)->post('/boards', [
            'title' => 'Test Board',
        ]);

        $response->assertSessionHasErrors('description');
        $this->assertDatabaseCount('boards', 0);
    }
}
