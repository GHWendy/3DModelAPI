<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GroupTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    // public function test_create_a_group_with_unauthenticated_user()
    // {

    //     $response = $this->json('POST', '/api/v1/groups/');
    //     $response->assertStatus(401);
    //     $response->assertJsonFragment(
    //         [
    //             "errors" => [
    //                 "code" => "ERROR-2",
    //                 "title" => "Unauthorized",
    //                 "detail" => "You need to authenticate"
    //             ]
    //         ]
    //     );
    // }


}
