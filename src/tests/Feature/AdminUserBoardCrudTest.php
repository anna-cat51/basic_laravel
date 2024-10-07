<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Models\User;
use App\Models\Board;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUserBoardCrudTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_see_user_list()
    {
        $admin = AdminUser::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/users');

        $response->assertStatus(200);
        $users = User::all();
        foreach ($users as $user) {
            $response->assertSee($user->name);
        }
    }

    /** @test */
    public function admin_can_edit_user()
    {
        $admin = AdminUser::factory()->create();
        $this->actingAs($admin, 'admin');
        $user = User::factory()->create();

        $response = $this->put("/admin/users/{$user->id}", [
            'user_name' => 'Updated Name',
            'user_email' => 'updated@example.com',
        ]);

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
        ]);
    }

    /** @test */
    public function admin_can_delete_user()
    {
        $admin = AdminUser::factory()->create();
        $this->actingAs($admin, 'admin');
        $user = User::factory()->create();

        $response = $this->delete("/admin/users/{$user->id}");

        $response->assertRedirect('/admin/users');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function admin_can_see_board_list()
    {
        $admin = AdminUser::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin/boards');

        $response->assertStatus(200);
        $boards = Board::all();
        foreach ($boards as $board) {
            $response->assertSee($board->title);
        }
    }

    /** @test */
    public function admin_can_edit_board()
    {
        $admin = AdminUser::factory()->create();
        $this->actingAs($admin, 'admin');
        $user = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user->id]);

        $response = $this->put("/admin/boards/{$board->id}", [
            'board_title' => 'Updated Title',
            'board_description' => 'Updated Description',
        ]);

        $response->assertRedirect('/admin/boards');
        $this->assertDatabaseHas('boards', [
            'id' => $board->id,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);
    }

    /** @test */
    public function admin_can_delete_board()
    {
        $admin = AdminUser::factory()->create();
        $this->actingAs($admin, 'admin');
        $user = User::factory()->create();
        $board = Board::factory()->create(['user_id' => $user->id]);

        $response = $this->delete("/admin/boards/{$board->id}");

        $response->assertRedirect('/admin/boards');
        $this->assertDatabaseMissing('boards', ['id' => $board->id]);
    }
}
