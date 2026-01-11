<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_user_list()
    {
        User::factory()->count(3)->create();

        $response = $this->actingAs($this->admin)
                         ->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertViewHas('users');
    }

    public function test_admin_can_create_new_user()
    {
        $data = [
            'name' => 'New Cashier',
            'email' => 'cashier@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'cashier',
        ];

        $response = $this->actingAs($this->admin)
                         ->post(route('admin.users.store'), $data);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'cashier@example.com',
            'role' => 'cashier',
        ]);
    }

    public function test_admin_can_update_user()
    {
        $user = User::factory()->create([
            'name' => 'Old Name',
            'role' => 'customer'
        ]);

        $data = [
            'name' => 'New Name',
            'email' => $user->email,
            'role' => 'admin',
        ];

        $response = $this->actingAs($this->admin)
                         ->put(route('admin.users.update', $user->id), $data);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New Name',
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)
                         ->delete(route('admin.users.destroy', $user->id));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
