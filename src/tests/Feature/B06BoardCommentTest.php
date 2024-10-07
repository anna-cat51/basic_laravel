<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class B06BoardCommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_comment_on_a_board()
    {
        $user = \App\Models\User::factory()->create();
        $board = \App\Models\Board::factory()->create(['user_id' => $user->id]);
        $this->actingAs($user);

        $comment = [
            'board_id' => $board->id,
            'body' => 'test comment',
        ];

        $response = $this->post(route("boards.comments.store", $board), $comment);
        $response->assertStatus(200);

        $this->assertDatabaseHas('comments', $comment);
    }

    /** @test */
    public function a_user_can_see_comments_on_a_board()
    {
        $user = \App\Models\User::factory()->create();
        $board = \App\Models\Board::factory()->create(['user_id' => $user->id]);

        $comment = \App\Models\Comment::factory()->create([
            'board_id' => $board->id,
            'user_id' => $user->id
        ]);
        $this->actingAs($user);

        $response = $this->get(route("boards.show", $board->id));
        $response->assertStatus(200);
        $response->assertSee($board->title);
        $response->assertSee($comment->body);
    }
}
