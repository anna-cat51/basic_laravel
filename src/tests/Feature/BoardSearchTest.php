<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Board;

class BoardSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_with_matching_query()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create([
            'title' => 'Laravel Test',
            'description' => 'This is a test board',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get('/boards/search?search=Laravel');

        $response->assertStatus(200);
        $response->assertSee($board->title);
    }

    public function test_search_with_non_matching_query()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create([
            'title' => 'Laravel Test',
            'description' => 'This is a test board',
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get('/boards/search?q=Symfony');

        $response->assertStatus(200);
        $response->assertDontSee($board->title);
    }

    public function test_search_with_empty_query()
    {
        $user = User::factory()->create();
        $board1 = Board::factory()->create(['user_id' => $user->id]);
        $board2 = Board::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get('/boards/search?q=');

        $response->assertStatus(200);
        $response->assertSee($board1->title);
        $response->assertSee($board2->title);
    }
}
