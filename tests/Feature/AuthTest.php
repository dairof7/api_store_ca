<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Database\Seeders\UserSeeder;

class AuthTest extends TestCase
{

    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // $this->seed(RoleSeeder::class);

        $this->seed(UserSeeder::class);
    }

    #[Test]
    public function an_existing_user_can_login(): void
    {
        # teniendo
        $credentials = ['email' => 'sdsdd3@gfg.com', 'password' => 'Emi08529'];
        # haciendo
        $response = $this->postJson("{$this->apiBase}/login", $credentials);
        #esperando
        $response->assertStatus(200);
        $response->assertJsonStructure(['data' => ['token']]);
    }

    public function a_non_existing_user_cannot_login(): void
    {
        # teniendo
        $credentials = ['email' => 'example@nonexisting.com', 'password' => 'ASDSA'];

        # haciendo
        $response = $this->postJson("api/v1/login", $credentials);

        #esperando
        $response->assertStatus(401);
        $response->assertJsonFragment(['status' => 401, 'message' => 'Unauthorized']);
    }

    public function email_must_be_required(): void
    {
        # teniendo
        $credentials = ['password' => 'password'];

        # haciendo
        $response = $this->postJson("api/v1/login", $credentials);

        #esperando
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'data', 'status', 'errors' => ['email']]);
        $response->assertJsonFragment(['errors' => ['email' => ['The email field is required.']]]);
    }

    public function email_must_be_valid_email(): void
    {
        # teniendo
        $credentials = ['email' => 'adasdasasd', 'password' => 'password'];

        # haciendo
        $response = $this->postJson("api/v1/login", $credentials);

        #esperando
        $response->assertStatus(422);
        $response->assertJsonStructure(['message', 'data', 'status', 'errors' => ['email']]);
        $response->assertJsonFragment(['errors' => ['email' => ['The email field must be a valid email address.']]]);
    }

}
