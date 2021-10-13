<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TipoTest extends TestCase
{
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
    public function get_all_locals()
    {
        $header = [
            "HTTP_ACCEPT" => "application/ld+json",
        ];

        $response = $this->get('api/tipo', $header);

        $response->assertJsonFragment(["mochilão"]);

    }
}
