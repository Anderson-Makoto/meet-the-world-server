<?php

namespace Tests\Feature;

use App\Http\Controllers\api\UserController;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan("migrate");
        $this->artisan('db:seed');
        $this->artisan('db:seed', ['--class' => 'TestData']);
    }

    /** @test */
    public function verify_if_register_valid_user()
    {

        $data = [
            "name" => "tomako",
            "email" => "tomako@email.com",
            "password" => "123123",
            "local_id" => 1,
            "tipo_id" => 1,
            "budget" => 1500.5
        ];

        $response = $this->post("api/user/register", $data);

        $response->assertCreated();
    }

    /** @test */
    public function verify_if_throw_error_if_register_an_already_registered_email()
    {
        $data = [
            "name" => "tomako",
            "email" => "samir@email.com",
            "password" => "123123",
            "local_id" => 1,
            "tipo_id" => 1,
            "budget" => 1500.5
        ];

        $response = $this->post("api/user/register", $data);

        $response->assertStatus(402);
    }

    /** @test */
    public function verify_registry_data_validation()
    {
        $data = [
            // "name" => "tomako",
            "email" => "tomako@email.com",
            "password" => "123123",
            // "local_id" => 1,
            "tipo_id" => 1,
            "budget" => 1500.5
        ];

        $response = $this->post("api/user/register", $data);

        $response->assertInvalid(["name", "local_id"]);
    }

    /** @test */
    public function verify_if_login_is_working_with_valid_email()
    {
        $data = [
            "email" => "anderson@email.com",
            "password" => "123123"
        ];

        $response = $this->post("api/user/login", $data);

        $response->assertJsonFragment([
            "name" => "Anderson Makoto"
        ]);
    }

    /** @test */
    public function verify_if_login_throw_error_for_invalid_email()
    {
        $data = [
            "email" => "invalid@email.com",
            "password" => "123132"
        ];

        $response = $this->post("api/user/login", $data);

        $response->assertStatus(404);
    }

    /** @test */
    public function verify_if_login_throws_error_if_password_is_invalid()
    {
        $data = [
            "email" => "anderson@email.com",
            "password" => "invalidPassword"
        ];

        $response = $this->post("api/user/login", $data);

        $response->assertStatus(402);
    }

    /** @test */
    public function verify_if_data_is_valid_in_login()
    {
        $data = [
            "email" => "anderson@email.com",
            // "password" => "123123"
        ];

        $response = $this->post("api/user/login", $data);

        $response->assertInvalid(["password"]);
    }

    /** @test */
    public function verify_if_logout_is_working()
    {

        $loginData = [
            "email" => "anderson@email.com",
            "password" => "123123"
        ];

        $loginUser = $this->post("api/user/login", $loginData);

        $header = [
            "HTTP_ACCEPT" => "application/ld+json",
            "HTTP_AUTHORIZATION" => "Bearer " . $loginUser->decodeResponseJson()["token"]
        ];

        $response = $this->get("api/user/logout/1", $header);

        $response->assertStatus(200);
    }
}
