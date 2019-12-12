<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_a_new_user_on_database()
    {
        //$user = [factory(User::class)->make()]; //['data' => factory(User::class)->create()];
        $user = [
            "data" => [
                "attributes" => [
                    "name" => "Ale",
                    "email" => "alex1@a.com",
                    "password" => "1234"
                ],
            ]
        ]; //
        $response = $this->json('POST', '/api/v1/users/', $user);
        $response->assertStatus(201);
        $response->assertJsonStructure([
            'data' => [
                'attributes' => [
                    'name',
                    'email',
                ]
            ]
        ]);

        $body = $response->decodeResponseJson();

        $response->assertJsonFragment(
            [
                'id' => $body['data']['id'],
                'attributes' => [
                    'name' => 'Ale',
                    'email' => 'alex1@a.com',
                ],
            ]
        );

        $this->assertDatabaseHas('users', [
            'id' => $body['data']['id'],
            'name' => 'Ale',
            'email' => 'alex1@a.com'
        ]);
    }

    public function test_show_all_users_on_database()
    {
        factory(User::class,2)->create();
        // $user = factory(User::class)->create(['name' => 'alex', 'email' => 'alex2', 'id' => '2']);
        $response = $this->json('GET', '/api/v1/users/');
        $response->assertStatus(200);

        $response->assertJsonStructure(
            [
                'data' => [
                    [
                        'id',
                        'attributes' => [
                            'name',
                            'email'
                        ]

                    ],
                ],
            ]
        );

        $body = $response->decodeResponseJson();
        // $response->assertJsonFragment(
        //     [
        //         'id' => $body['data']['id'],
        //         'attributes' => [
        //             'name' => $body['data']['name'],
        //             'email' => $body['data']['email'],
        //         ],
        //     ]
        // );
        //$users = User::all();
        // UserCollection($users);
        // $response->assertJson([]);
    }

    public function test_show_all_users_on_database_when_is_empty()
    {
        $response = $this->json('GET', '/api/v1/users/');
        $response->assertStatus(200);
        $response->assertJsonFragment(
            [
                'data' => []
            ]
        );
    }
}
