<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function userwithRole(string $role): User
    {
        return User::factory()->create([
            'role' => $role,
            'must_change_password' => false,
        ]);
    }

    public function test_warehouse_staff_can_open_articles(): void
    {
        $response = $this->actingAs($this->userWithRole('lagermitarbeiter'))->get('/articles');
        $response->assertOk();
    }

    public function test_cashier_cannot_open_articles(): void
    {
        $response = $this->actingAs($this->userWithRole('kassenkraft'))->get('/articles');
        $response->assertForbidden();
    }

    public function test_admin_can_open_user_management(): void
    {
        $response = $this->actingAs($this->userWithRole('administrator'))->get('/users');
        $response->assertOk();
    }

    public function test_customer_can_open_portal(): void
    {
        $response = $this->actingAs($this->userWithRole('kunde'))->get('/portal');
        $response->assertOk();
    }

    public function test_staff_cannot_open_customer_portal(): void
    {
        $roles = ['kassenkraft', 'administrator', 'lagermitarbeiter', 'spediteur'];
        foreach ($roles as $role) {
            $response = $this->actingAs($this->userWithRole($role))->get('/portal');
            $response->assertForbidden();
        }
    }

}
