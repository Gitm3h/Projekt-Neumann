<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class LoginThrottleTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_is_blocked_after_too_many_attempts(): void
    {
        $user = User::factory()->create([
            'must_change_password' => false,
        ]);

        foreach (range(1, 4) as $attempt)
        {
            $response = $this->post('/login',[
                'email' => $user->email,
                 'password' => 'wrong-password',
                ]);
        }

        $response->assertSessionHasErrors('email');
    }
}
