<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class B08BoardEditDelete extends TestCase
{
    use DatabaseMigrations;

    /**
     * Test authenticated user can edit a board.
     *
     * @return void
     */
    public function test_authenticated_user_can_edit_board()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(["user_id" => $user->id]);
        $this->actingAs($user);

        $response = $this->get("/boards/{$board->id}/edit");
        $response->assertOk();
    }

    /**
     * Test authenticated user can update a board.
     *
     * @return void
     */
    public function test_authenticated_user_can_update_board()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(["user_id" => $user->id]);

        $this->actingAs($user);

        $updatedTitle = 'Updated Title';
        $updatedDescription = 'Updated Description';
        $updatedImage = UploadedFile::fake()->image('test.png');

        $response = $this->put("/boards/{$board->id}", [
            'title' => $updatedTitle,
            'description' => $updatedDescription,
            'image' => $updatedImage,
        ]);

        $response->assertRedirect("/boards/{$board->id}");
        $response->assertSessionHas('success');

        $updatedBoard = Board::find($board->id);
        $this->assertEquals($updatedTitle, $updatedBoard->title);
        $this->assertEquals($updatedDescription, $updatedBoard->description);
        Storage::disk('public')->assertExists($board->image_path);
    }

    /**
     * Test authenticated user can delete a board.
     *
     * @return void
     */
    public function test_authenticated_user_can_delete_board()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create(["user_id" => $user->id]);
        $this->actingAs($user);

        $response = $this->delete("/boards/{$board->id}");

        $response->assertRedirect('/boards');
        $response->assertSessionHas('success');

        $deletedBoard = Board::find($board->id);
        $this->assertNull($deletedBoard);
    }
}
