<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Board;
use App\Models\Bookmark;

class B10BookmarkButtonTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_add_bookmark()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->post(route('bookmarks.store', ['board' => $board->id]));

        $response->assertStatus(200);
        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user->id,
            'board_id' => $board->id,
        ]);
    }

    public function test_user_can_remove_bookmark()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user->id]);
        $bookmark = Bookmark::create([
            'user_id' => $user->id,
            'board_id' => $board->id,
        ]);

        $this->actingAs($user);

        $response = $this->delete(route('bookmarks.destroy', ['board' => $board->id]));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('bookmarks', [
            'user_id' => $user->id,
            'board_id' => $board->id,
        ]);
    }
}
