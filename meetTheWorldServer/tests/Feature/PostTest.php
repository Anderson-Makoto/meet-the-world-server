<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    private $token = "";

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan("migrate");
        $this->artisan('db:seed');
        $this->artisan('db:seed',['--class' => 'TestData']);

        $loginData = [
            "email" => "anderson@email.com",
            "password" => "123123"
        ];

        $loginUser = $this->post("api/user/login", $loginData);

        $this->token = "Bearer ".$loginUser->decodeResponseJson()["token"];
    }

    /** @test */
    public function create_new_post_for_user_with_id_1 () {
        $header = [
            "HTTP_ACCEPT" => "application/ld+json",
            "HTTP_AUTHORIZATION" => $this->token
        ];

        $data = [
            "local_id" => 170,
            "tipo_id" => 0,
            "user_id" => 1,
            "date" => "01-01-2019",
            "price" => 8000,
            "title" => "Local do Nepal usuario 1",
            "description" => "descrição da viagem do nepal"
        ];
        
        $response = $this->post("api/post", $data, $header);

        $response->assertStatus(201);
    }

    /** @test */
    public function verify_if_cant_create_posts_for_unauthorized_users () {
        $header = [
            "HTTP_ACCEPT" => "application/ld+json",
            "HTTP_AUTHORIZATION" => "Bearer wrongToken"
        ];

        $data = [
            "local_id" => 170,
            "tipo_id" => 0,
            "user_id" => 1,
            "date" => "01-01-2019",
            "price" => 8000,
            "title" => "Local do Nepal usuario 1",
            "description" => "descrição da viagem do nepal"
        ];

        $response = $this->post("api/post", $data, $header);

        $response->assertJsonFragment(["Unauthenticated."]);
    }

    /** @test */
    public function verify_if_return_all_posts_from_user () {
        $header = [
            "HTTP_ACCEPT" => "application/ld+json",
            "HTTP_AUTHORIZATION" => $this->token
        ];

        $response = $this->get("api/post", $header);

        $response->assertJsonCount(3, "data");
    }

    /** @test */
    public function verify_if_not_return_all_posts_for_unauthenticated_user () {
        $header = [
            "HTTP_ACCEPT" => "application/ld+json",
            "HTTP_AUTHORIZATION" => "Bearer wrongToken"
        ];

        $response = $this->get("api/post", $header);

        $response->assertJsonFragment(["Unauthenticated."]);
    }

    /** @test */
    public function return_post_by_id () {
        $header = [
            "HTTP_ACCEPT" => "application/ld+json",
            "HTTP_AUTHORIZATION" => $this->token
        ];

        $response = $this->get("api/post/2", $header);

        $response->assertJsonFragment(["Local da Bolívia usuario 1"]);
    }

    /** @test */
    public function verify_if_not_return_post_by_id_if_user_unauthorized () {
        $header = [
            "HTTP_ACCEPT" => "application/ld+json",
            "HTTP_AUTHORIZATION" => "Bearer wrongToken"
        ];

        $response = $this->get("api/post/2", $header);

        $response->assertJsonFragment(["Unauthenticated."]);
    }

    /** @test */
    public function delete_post_by_id () {
        $header = [
            "HTTP_ACCEPT" => "application/ld+json",
            "HTTP_AUTHORIZATION" => $this->token
        ];

        $response = $this->delete("api/post/2", [], $header);

        $response->assertStatus(200);
    }

    /** @test */
    public function get_resumed_posts () {
        $header = [
            "HTTP_ACCEPT" => "application/ld+json",
            "HTTP_AUTHORIZATION" => $this->token
        ];

        $response = $this->get("api/post/getPostsResume", $header);

        $response->assertJsonCount(2, "data");
    }
}
