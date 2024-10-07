<?php

namespace Tests\Feature\Admin;

use App\Models\AdminUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_dashboard_is_accessible_when_logged_in()
    {
        $admin = AdminUser::factory()->create();
        $this->actingAs($admin, 'admin');

        $response = $this->get('/admin');

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard');
    }

    /** @test */
    public function admin_login_page_is_displayed_when_not_logged_in()
    {
        $response = $this->get('/admin');

        $response->assertRedirect('/admin/login');
    }

    /** @test */
    public function admin_can_login_and_logout()
    {
        $admin = AdminUser::factory()->create([
            'password' => bcrypt($password = 'admin-password'),
        ]);

        // Login
        $response = $this->post('/admin/login', [
            'email' => $admin->email,
            'password' => $password,
        ]);

        $this->assertAuthenticated('admin');
        $response->assertRedirect('/admin');

        // Logout
        $response = $this->post('/admin/logout');

        $this->assertGuest('admin');
        $response->assertRedirect('/admin/login');
    }
}
