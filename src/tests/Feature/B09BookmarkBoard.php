<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class B09BookmarkBoard extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test if authenticated user can see board with heart icon.
     *
     * @return void
     */
    public function test_authenticated_user_can_see_board_with_heart_icon()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user2->id]);

        $this->actingAs($user1);

        // No bookmark
        $response = $this->get("/boards/{$board->id}");
        $response->assertSee('<i class="ri-heart-3-line', false);

        // Create bookmark
        Bookmark::create([
            'user_id' => $user1->id,
            'board_id' => $board->id,
        ]);

        // With bookmark
        $response = $this->get("/boards/{$board->id}");
        $response->assertSee('<i class="ri-heart-3-fill', false);
    }

    /**
     * Test if authenticated user can see all boards with heart icon.
     *
     * @return void
     */
    public function test_authenticated_user_can_see_all_boards_with_heart_icon()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user2->id]);

        $this->actingAs($user1);

        // No bookmark
        $response = $this->get("/boards");
        $response->assertSee('<i class="ri-heart-3-line', false);

        // Create bookmark
        Bookmark::create([
            'user_id' => $user1->id,
            'board_id' => $board->id,
        ]);

        // With bookmark
        $response = $this->get("/boards");
        $response->assertSee('<i class="ri-heart-3-fill', false);
    }

    /**
     * Test if authenticated user can create a bookmark.
     *
     * @return void
     */
    public function test_authenticated_user_can_create_a_bookmark()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user2->id]);

        $this->actingAs($user1);
        $this->get('/boards/' . $board->id);

        $response = $this->post("/boards/{$board->id}/bookmark");
        $response->assertRedirect('/boards/' . $board->id);

        $this->assertDatabaseHas('bookmarks', [
            'user_id' => $user1->id,
            'board_id' => $board->id,
        ]);
    }

    /**
     * Test if authenticated user can delete a bookmark.
     *
     * @return void
     */
    public function test_authenticated_user_can_delete_a_bookmark()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user->id]);
        $bookmark = Bookmark::create([
            'user_id' => $user->id,
            'board_id' => $board->id,
        ]);

        $this->actingAs($user);
        $this->get('/boards/' . $board->id);

        $response = $this->delete("/boards/{$board->id}/bookmark");
        $response->assertRedirect('/boards/' . $board->id);

        $this->assertModelMissing($bookmark);
    }
}
