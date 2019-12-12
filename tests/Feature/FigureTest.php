<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FigureTest extends TestCase
{

    public function test_create_a_figure_with_unauthenticated_user()
    {

        $response = $this->json('POST', '/api/v1/figures/');
        $response->assertStatus(401);
        $response->assertJsonFragment(
            [
                "errors" => [
                    "code" => "ERROR-2",
                    "title" => "Unauthorized",
                    "detail" => "You need to authenticate"
                ]
            ]
        );
    }

    public function test_show_all_figures_on_database_when_is_empty()
    {
        $response = $this->json('GET', '/api/v1/figures/');
        $response->assertStatus(200);
        $response->assertJsonFragment(
            []
        );
    }
}
