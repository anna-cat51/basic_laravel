<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use App\Models\Board;

class B04FormMessagesTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function testCreateBoardSuccess()
    {
        // ログイン処理
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        $attributes = [
            'title' => 'test title',
            'description' => 'test description'
        ];

        $response = $this->post('/boards', $attributes);

        $response->assertStatus(302);
        $response->assertRedirect('/boards');
        $this->assertDatabaseHas('boards', $attributes);
        $this->assertEquals(Session::get('success'), '掲示板を作成しました。');
    }

    /**
     * @test
     */
    public function testCreateBoardValidationFail()
    {
        // ログイン処理
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);

        $response = $this->post('/boards', [
            'title' => '',
            'description' => ''
        ]);

        $response->assertSessionHasErrors([
            'title' => 'タイトルは必ず指定してください。',
            'description' => '説明は必ず指定してください。'
        ]);
    }
}
