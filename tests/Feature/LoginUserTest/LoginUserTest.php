<?php

namespace Tests\Feature\LoginUserTest;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginUserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_login_and_receive_sanctum_token()
    {
        $response = $this->postJson('/api/v1/user/auth/login', [
            'email'        => 'user@example.com',
            'password'     => 'Password123!',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'msg',
                     'data' => [
                         'user' => [
                             'id',
                             'name',
                             'email',
                             'created_at',
                             'updated_at'
                         ],
                         'token'
                     ]
                 ]);

        $this->assertTrue($response['status']);
        $this->assertEquals('user@example.com', $response['data']['user']['email']);
        $this->assertIsString($response['data']['token']);
    }

     public function test_login_fails_with_wrong_password()
    {
        $response = $this->postJson('/api/v1/user/auth/login', [
            'email'         => 'user@example.com',
            'password'      => 'wrong-password',
        ]);

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'status',
                     'msg',
                     'data'
                 ]);
    }

    public function test_login_fails_with_invalid_data()
    {
        $response = $this->postJson('/api/v1/user/auth/login', [
            'email'       => 'not-an-email',
            'password'    => '',
        ]);

        $response->assertStatus(422)
                 ->assertJsonStructure([
                     'status',
                     'msg',
                     'data'
                 ]);
    }

}
